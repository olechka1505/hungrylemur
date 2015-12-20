<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * woocommerce_before_single_product_summary hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		//do_action( 'woocommerce_before_single_product_summary' );
	?>
	
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<img src="<?php echo get_post_meta( get_the_ID(), 'wpcf-featured-image', true ); ?>" ><!-- .featured image -->
	</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 summary entry-summary">

		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>
		</div><!-- .summary -->
	
		
	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
	
	

	<meta itemprop="url" content="<?php the_permalink(); ?>" />
	
	<!-- Cart Track -->
	
	<?php
	if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
	}

	global $product;

	if ( ! $product->is_purchasable() ) {
	return;
	}

	?>

	<?php
	
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
	echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
	?>
	
	<!-- Custom Fields Product -->
	
		<!-- Product Image 1 -->
		<div class="product-image-upload">
			<img src="<?php echo get_post_meta( get_the_ID(), 'wpcf-product-image1', true ); ?>" >
		</div>
		<!-- End of Product Image 1 -->
		
		<!-- Product Title and Subtitle -->
		<div class="custom-fields-product">	
			<h2><?php echo get_post_meta( get_the_ID(), 'wpcf-product-title', true ); ?></h2>
			<p><?php echo get_post_meta( get_the_ID(), 'wpcf-product-subtitle', true ); ?></p>
		</div>	
		<!-- End of Product Title and Subtitle -->
		
		<!-- Product Image 2 -->		<?php $product_image2 = get_post_meta( get_the_ID(), 'wpcf-product-image2', true );?>		<?php if (!empty($product_image2)) { ?>		 	<div class="product-image-upload">				<img src="<?php echo  $product_image2 ?>" >			</div>		<?php } ?>		
		<!-- Product Image 3 -->		<?php $product_image3 = get_post_meta( get_the_ID(), 'wpcf-product-image3', true );?>		<?php if (!empty($product_image3)) { ?>		 	<div class="product-image-upload">				<img src="<?php echo  $product_image3 ?>" >			</div>		<?php } ?>
		<!-- Product Image 4 -->		<?php $product_image4 = get_post_meta( get_the_ID(), 'wpcf-product-image-4', true );?>		<?php if (!empty($product_image4)) { ?>		 	<div class="product-image-upload">				<img src="<?php echo  $product_image4 ?>" >			</div>		<?php } ?>
		<!-- Product Image 5 -->		<?php $product_image5 = get_post_meta( get_the_ID(), 'wpcf-product-image-5', true );?>		<?php if (!empty($product_image5)) { ?>		 	<div class="product-image-upload">				<img src="<?php echo  $product_image5 ?>" >			</div>		<?php } ?>

		<!-- Product Image 6 -->		<?php $product_image6 = get_post_meta( get_the_ID(), 'wpcf-product-image-6', true );?>		<?php if (!empty($product_image6)) { ?>		 	<div class="product-image-upload">				<img src="<?php echo  $product_image6 ?>" >			</div>		<?php } ?>

		<!-- Product Image 7 -->		<?php $product_image7 = get_post_meta( get_the_ID(), 'wpcf-product-image-7', true );?>		<?php if (!empty($product_image7)) { ?>		 	<div class="product-image-upload">				<img src="<?php echo  $product_image7 ?>" >			</div>		<?php } ?>

		<!-- Product Image 8 -->		<?php $product_image8 = get_post_meta( get_the_ID(), 'wpcf-product-image-8', true );?>		<?php if (!empty($product_image8)) { ?>		 	<div class="product-image-upload">				<img src="<?php echo  $product_image8 ?>" >			</div>		<?php } ?>
	
	<?php
						echo get_post_meta( $post_id, '_text_field', true );
						?>
	<!-- ./Custom Fields Product -->
	
	<!-- Cart Track -->
	
	<?php
	if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
	}

	global $product;

	if ( ! $product->is_purchasable() ) {
	return;
	}

	?>

	<?php
	
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
	echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
	?>

	<?php if ( $product->is_in_stock() ) : ?>
	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
	<div class="single-product-cart-track cart-visible">
	<form class="cart" method="post" enctype='multipart/form-data'>
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	 	<?php
	 		/*if ( ! $product->is_sold_individually() ) {
	 			woocommerce_quantity_input( array(
	 				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
	 				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
	 				'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
	 			) );
	 		}*/
	 	?>
		
	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />

	<button type="submit" class="single_add_to_cart_button button alt single-product-buy-now">Buy Now</button>
	<div class="single-product-cart-price">
	<?php echo $product->get_price_html(); ?>
	</div>
	<div class="single-product-cart-title">
	<?php the_title(); ?>
	</div>
	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>
	</div>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

	<?php endif; ?>
	
	<!-- Cart Track -->	
	
</div><!-- #product-<?php the_ID(); ?> -->


<script type="text/javascript">
    /*============ Hiding (the fixed bar) when scrolling reach to footer ==============*/
    jQuery(window).scroll(function () {
        var bar = jQuery('.single-product-cart-track.cart-visible');
        var targetOffset = jQuery('#main').offset().top;
        var targetHeight = jQuery('#main').outerHeight();
        var windowHeight = jQuery(window).height();
        var scrollTracker = jQuery(this).scrollTop();

        //console.log((targetOffset - windowHeight), scrollTracker);

        if (scrollTracker < (targetOffset + targetHeight - windowHeight)) {
            jQuery(bar).css('position', 'fixed');
        } else {
            jQuery(bar).css('position', 'inherit');
        }
    });
</script>
