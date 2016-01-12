<?php
/*
  Plugin Name: Smart Variations Images
  Plugin URI: http://www.rosendo.pt
  Description: This is a WooCommerce extension plugin, that allows the user to add any number of images to the product images gallery and be used as variable product variations images in a very simple and quick way, without having to insert images p/variation.
  Author: David Rosendo
  Version: 1.5.2
  Author URI: http://www.rosendo.pt
 */

if ( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {


	class woocommerce_svi {

		function __construct() {
			$this->rosendolink = 'http://www.rosendo.pt';
			$this->title = __( 'Smart Variations Images for WooCommerce', 'wc_svi' );
			$this->menutitle = __( 'SVI', 'wc_svi' );
			$this->woosvi_defaultprod = get_option( 'woosvi_defaultprod' );
			$this->woosvi_activate = get_option( 'woosvi_activate' );
			$this->woosvi_columns = get_option( 'woosvi_columns' );
			$this->woosvi_lightbox = get_option( 'woosvi_lightbox' );
			$this->load_plugin_textdomain();

			if ( is_admin() || (is_multisite() && is_network_admin()) ) {

				add_action( 'admin_enqueue_scripts', array( $this, 'woo_svi_scripts_admin' ) );
				add_action( 'admin_init', array( $this, 'settings_init' ) );
				add_action( 'admin_menu', array( $this, 'menu' ) );


				add_filter( 'attachment_fields_to_edit', array( $this, 'woo_svi_field' ), 10, 2 );
				add_filter( 'attachment_fields_to_save', array( $this, 'woo_svi_field_save' ), 10, 2 );
			} else {

				add_action( 'wp_enqueue_scripts', array( $this, 'woo_svi_scripts' ), 100 );



				add_filter( 'wp_get_attachment_image_attributes', array( $this, 'add_woovsi_attribute' ), 10, 2 );

				add_action( 'template_redirect', array( $this, 'remove_gallery_and_product_images' ) );
				add_action( 'wp_print_scripts', array( $this, 'localize_script' ), 5 );
			}
		}

		function load_plugin_textdomain() {
			load_plugin_textdomain( 'wc_svi', false, plugin_basename( dirname( __FILE__ ) ) . "/languages" );
		}

		function menu() {
			add_submenu_page( 'woocommerce', $this->title, $this->menutitle, 'manage_woocommerce', 'woocommerce_svi', array( $this, 'options_page' ) );
		}

		function settings_init() {
			$settings = array();


			$settings[] = $this->formSVI();
			$settings[] = $this->wc_svi_gopro();

			foreach ( $settings as $sections => $section ) {
				add_settings_section( $section['name'], $section['title'], array( $this, $section['name'] ), $section['page'] );
				if ( !empty( $section['settings'] ) ) {
					foreach ( $section['settings'] as $setting => $option ) {
						add_settings_field( $option['name'], $option['title'], array( $this, $option['name'] ), $section['page'], $section['name'] );
						register_setting( $section['page'], $option['name'] );
						$this->$option['name'] = get_option( $option['name'] );
					}
				}
			}
		}

		function wc_svi_gopro() {
			return array(
				'name' => 'wc_svi_gopro',
				'title' => __( 'Take SVI to the next level, go PRO!', 'wc_svi' ),
				'page' => 'woocommerce_svi_gopro'
			);
		}

		function formSVI() {
			return array(
				'name' => 'wc_svi_settings',
				'title' => __( 'SVI setting', 'wc_svi' ),
				'page' => 'woocommerce_svi',
				'settings' => array(
					array(
						'name' => 'woosvi_activate',
						'title' => __( 'Activate Lens Zoom', 'wc_svi' ),
					),
					array(
						'name' => 'woosvi_columns',
						'title' => __( 'Columns', 'wc_svi' ),
					),
					array(
						'name' => 'woosvi_lightbox',
						'title' => __( 'Enable Ligthbox', 'wc_svi' ),
					),
					array(
						'name' => 'woosvi_defaultprod',
						'title' => __( 'Enable WooCommerce default product image', 'wc_svi' ),
					),
				),
			);
		}

		function wc_svi_settings() {
			echo '<p>' . __( 'Please setup SVI to work as you need.', 'wc_svi' ) . '</p>';
		}

		function woosvi_columns( $val ) {
			$val = $this->woosvi_columns;
			if ( empty( $this->woosvi_columns ) || $this->woosvi_columns < 2 )
				$val = 3;
			echo '<input type="number" name="woosvi_columns" min="2" id="woosvi_columns" placeholder="3" value="' . $val . '" />';
			echo ' <label for="woosvi_columns">Number of columns(images) p/row, min: 2</label>';
		}

		function woosvi_lightbox() {
			echo '<input type="checkbox" name="woosvi_lightbox" id="woosvi_lightbox" class="" value="1" ' . checked( $this->woosvi_lightbox, 1, false ) . '>';
			echo ' <label for="woosvi_lightbox">' . __( 'Activate ligthbox', 'wc_svi' ) . '</label>';
		}

		function woosvi_activate() {
			echo '<input type="checkbox" name="woosvi_activate" id="woosvi_activate" class="" value="1" ' . checked( $this->woosvi_activate, 1, false ) . '>';
			echo ' <label for="woosvi_activate">' . __( 'This will activate Lens Zoom, check demo here: <a href="http://www.rosendo.pt/en/product/ship-your-idea/" target="_blank">rosendo.pt</a>', 'wc_svi' ) . '</label>';
		}

		function woosvi_defaultprod() {
			echo '<input type="checkbox" name="woosvi_defaultprod" id="woosvi_defaultprod" class="" value="1" ' . checked( $this->woosvi_defaultprod, 1, false ) . '>';
			echo ' <label for="woosvi_defaultprod">' . __( 'Note: Will disable above options', 'wc_svi' ) . '</label>';
		}

		function options_page() {
			?>
			<div class="wrap">
				<center>
					<h2><?php echo $this->title; ?></h2>
					<small>by <a class="rosendo_logo" href="<?php echo $this->rosendolink; ?>" target="_blank">rosendo wDev</a></small>
				</center>

				<div id="icon-themes" class="icon32"></div>
				<?php settings_errors(); ?>
				<?php
				$active_tab = 'woocommerce_svi';

				if ( isset( $_GET['tab'] ) ) {
					$active_tab = $_GET['tab'];
				}
				?>
				<h2 class="nav-tab-wrapper">
					<a href="?page=woocommerce_svi&tab=woocommerce_svi" class="nav-tab <?php echo $active_tab == 'woocommerce_svi' ? 'nav-tab-active' : ''; ?>">Settings</a>
					<a href="?page=woocommerce_svi&tab=woocommerce_svi_gopro" class="nav-tab <?php echo $active_tab == 'woocommerce_svi_gopro' ? 'nav-tab-active' : ''; ?>">Go PRO</a>
				</h2>
				<?php
				if ( $active_tab == 'woocommerce_svi' ) {
					?>
					<form method="post" id="mainform" action="options.php">

						<?php
						settings_fields( 'woocommerce_svi' );
						do_settings_sections( 'woocommerce_svi' );
						submit_button();
						?>


					</form>
					<?php
				}

				if ( $active_tab == 'woocommerce_svi_gopro' ) {
					settings_fields( 'woocommerce_svi_gopro' );
					do_settings_sections( 'woocommerce_svi_gopro' );
					?>
					<h4>The pro version is <strong>still in development</strong> and will carry the following features:</h4>
					<ul>
						<li>* Fully responsive and mobile ready slider</li>
						<li>* Slider for main product image</li>
						<li>* Vertical/Horizontal slider for product thumbnail</li>
						<li>* Unlimited images</li>
						<li>* Custom number of slider items to show in thumbnail</li>
						<li>* Better theme compatability</li>
						<li>* 1 year <strong>Priority support</strong></li>
						<li>and more...</li>
					</ul>
					<br><br>
					<h5>Donate for this project!</h5>
					<h4><a href="https://goo.gl/EPQAsA" target="_blank">Donate!</a></h4>

					<small>ETA: 1/02/2016</small>

					<?php
				}
				?>
				<center><a href="https://wordpress.org/support/view/plugin-reviews/smart-variations-images" target="_blank"><img src="<?php echo plugins_url( '/assets/images/review.png', __FILE__ ); ?>"></a></center>

			</div>
			<?php
		}

		function woo_svi_filter_woocommerce_product_thumbnails_columns( $number ) {
			$number = get_option( 'woosvi_columns' );
			if ( empty( $number ) || $number < 1 )
				$number = 3;

			return $number;
		}

		/**
		 * Remove default Product Images
		 *
		 */
		function remove_gallery_and_product_images() {
			if ( is_product() ) {
				if ( $this->woosvi_defaultprod == '' ) {
					add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'woo_svi_filter_woocommerce_product_thumbnails_columns' ), 11, 1 );
					add_filter( 'woocommerce_locate_template', array( $this, 'woo_svi_locate_template' ), 10, 3 );
				}
			}
		}

		function woo_svi_plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		function woo_svi_locate_template( $template, $template_name, $template_path ) {

			global $woocommerce;

			$_template = $template;

			if ( !$template_path )
				$template_path = $woocommerce->template_url;

			$plugin_path = $this->woo_svi_plugin_path() . '/woocommerce/';
// Look within passed path within the theme - this is priority

			$template = locate_template(
					array(
						$template_path . $template_name,
						$template_name
					)
			);

// Modification: Get the template from this plugin, if it exists

			if ( file_exists( $plugin_path . $template_name ) ) {
				$template = $plugin_path . $template_name;
			}


// Use default template

			if ( !$template )
				$template = $_template;

// Return what we found
			return $template;
		}

		/**
		 * Add admin woovsi scripts
		 *
		 */
		function woo_svi_scripts_admin() {
			$screen = get_current_screen();
			$loads = array(
				'jquery-core'
			);
			if ( $screen->base == 'woocommerce_page_woocommerce_svi' )
				wp_enqueue_script( 'woo_svijs', plugin_dir_url( __FILE__ ) . 'assets/js/woo_svi_admin.js', $loads, null, true );
		}

		/**
		 * Add woovsi scripts
		 *
		 */
		function woo_svi_scripts() {
			global $wp_styles;
			$srcs = array_map( 'basename', (array) wp_list_pluck( $wp_styles->registered, 'src' ) );

			$key_woocommerce = array_search( 'woocommerce.css', $srcs );

			$loads = array(
				'jquery'
			);
			wp_enqueue_script( 'woo_svijs', plugin_dir_url( __FILE__ ) . 'assets/js/woo_svi.min.js', $loads, null, true );

			$styles = null;

			if ( $key_woocommerce ) {
				$styles = array(
					$key_woocommerce
				);
			}

			wp_enqueue_style( 'woo_svicss', plugin_dir_url( __FILE__ ) . 'assets/css/woo_svi.min.css', $styles, null );

			wp_deregister_script( 'wc-add-to-cart-variation' );
		}

		function localize_script() {
			$handle = 'woo_svijs';
			$data = array(
				'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'woocommerce' ),
				'i18n_unavailable_text' => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' ),
			);
			$name = str_replace( '-', '_', $handle ) . '_params';
			wp_localize_script( $handle, $name, apply_filters( $name, $data ) );
		}

		/**
		 * Add woovsi product image to product page
		 *
		 */

		/**
		 * Add woovsi thumbnail to product page
		 *
		 */
		function woo_svi_images_thumbs() {
			global $post, $product;

			$attachment_ids = $product->get_gallery_attachment_ids();

			if ( $attachment_ids ) {
				$loop = 0;
				$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
				?>
				<div class="thumbnails <?php echo 'columns-' . $columns; ?>"><?php
					foreach ( $attachment_ids as $attachment_id ) {

						$classes = array( 'noLightbox', 'zoom' );

						if ( $loop == 0 || $loop % $columns == 0 )
							$classes[] = 'first';

						if ( ( $loop + 1 ) % $columns == 0 )
							$classes[] = 'last';

						$image_link = wp_get_attachment_url( $attachment_id );

						if ( !$image_link )
							continue;

						$image_title = esc_attr( get_the_title( $attachment_id ) );
						$image_caption = esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

						$image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
							'title' => $image_title,
							'alt' => $image_title
						) );

						$data_woovsi = get_post_meta( $attachment_id, 'woosvi_slug', true );

						$image_class = esc_attr( implode( ' ', $classes ) );

						echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[%s]">%s</a>', $image_link, $image_class, $image_caption, $data_woovsi, $image ), $attachment_id, $post->ID, $image_class );

						$loop++;
					}
					?></div>
				<?php
			}
		}

		/**
		 * Add woovsi field to media uploader
		 *
		 * @param $form_fields array, fields to include in attachment form
		 * @param $post object, attachment record in database
		 * @return $form_fields, modified form fields
		 */
		function woo_svi_field( $form_fields, $post ) {

			if ( isset( $_POST['post_id'] ) && $_POST['post_id'] != '0' ) {

				$wc = new WC_Product( $_POST['post_id'] );
				$att = $wc->get_attributes();

				if ( !empty( $att ) ) {

					$current = get_post_meta( $post->ID, 'woosvi_slug', true );

					$html = "<select name='attachments[{$post->ID}][woosvi-slug]' id='attachments[{$post->ID}][woosvi-slug]'>";

					$variations = false;

					$html .= "<option value='' " . selected( $current, '', false ) . ">none</option>";

					foreach ( $att as $key => $attribute ) {
						if ( $attribute['is_taxonomy'] ) {

							$terms = wp_get_post_terms( $_POST['post_id'], $key, 'all' );


							if ( !empty( $terms ) ) {
								$variations = true;
								foreach ( $terms as $term ) {
									$html .= "<option value='" . $term->slug . "' " . selected( $current, $term->slug, false ) . ">" . $term->name . "</option>";
								}
							}
						} else {
							$values = str_replace( " ", "", $attribute['value'] );
							$terms = explode( '|', $values );
							if ( !empty( $terms ) ) {
								$variations = true;
								foreach ( $terms as $term ) {
									$html .= "<option value='" . strtolower( $term ) . "' " . selected( $current, strtolower( $term ), false ) . ">" . $term . "</option>";
								}
							}
						}
					}

					$html .= '</select>';

					if ( $variations ) {
						$form_fields['woosvi-slug'] = array(
							'label' => 'Variation',
							'input' => 'html',
							'html' => $html,
							'application' => 'image',
							'exclusions' => array(
								'audio',
								'video'
							),
							'helps' => 'Choose the variation'
						);
					} else {
						$form_fields['woosvi-slug'] = array(
							'label' => 'Variation',
							'input' => 'html',
							'html' => 'This product doesn\'t seem to be using any variations.',
							'application' => 'image',
							'exclusions' => array(
								'audio',
								'video'
							),
							'helps' => 'Add variations to the product and Save'
						);
					}
				}
			}
			return $form_fields;
		}

		/**
		 * Save values of woovsi in media uploader
		 *
		 * @param $post array, the post data for database
		 * @param $attachment array, attachment fields from $_POST form
		 * @return $post array, modified post data
		 */
		function woo_svi_field_save( $post, $attachment ) {
			if ( isset( $attachment['woosvi-slug'] ) )
				update_post_meta( $post['ID'], 'woosvi_slug', $attachment['woosvi-slug'] );


			return $post;
		}

		function add_woovsi_attribute( $html, $post ) {
			$current = get_post_meta( $post->ID, 'woosvi_slug', true );

			$html['data-woovsi'] = $current;
			return $html;
		}

		function pre( $arg ) {
			echo "<pre>" . print_r( $arg, true ) . "</pre>";
		}

	}

	function start_svi() {
		global $wc_svi;

		if ( !isset( $wc_svi ) ) {
			$wc_svi = new woocommerce_svi();
		}

		return $wc_svi;
	}

	start_svi();
}