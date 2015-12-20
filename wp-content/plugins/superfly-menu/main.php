<?php
/*
Plugin Name: Superfly Menu
Plugin URI: http://superfly.looks-awesome.com
Description: Off-canvas hamburger menu for WordPress
Version: 2.1.8
Author: Looks Awesome
Author URI: http://looks-awesome.com
License: Commercial License
Text Domain: superfly-menu
Domain Path: /lang
*/

global $sf_options;

if (!defined('SF_VERSION_KEY')) {
	define('SF_VERSION_KEY', 'SF_version');
}

if (!defined('SF_VERSION_NUM')) {
	define('SF_VERSION_NUM', '2.1.8');
}

if( ! defined( 'SF_ITEM_META' ) )
	define( 'SF_ITEM_META' , '_sf_settings' );

add_option(SF_VERSION_KEY, SF_VERSION_NUM);

load_plugin_textdomain('superfly-menu', false, basename( dirname( __FILE__ ) ) . '/lang' );

include_once(dirname(__FILE__) . '/settings.php');

add_action('wp_enqueue_scripts', 'sf_scripts');

add_action( 'admin_menu', 'sf_menu' );

function sf_menu() {
	add_options_page( 'Superfly Menu Options', '<span style="display: inline-block;border-left:3px solid #d06808; padding-left:3px;position: relative;left: -6px;">Superfly Menu</span>', 'manage_options', 'superfly-menu-options', 'sf_page' );
}

add_action( 'admin_print_styles-nav-menus.php' , 'sf_menus_admin' );

/**
 * Appearance/Menus page in the WP Admin
 */
function sf_menus_admin() {
	wp_register_style('sf-menus-admin-css', plugins_url('/css/menu-admin.css', __FILE__));
	wp_enqueue_style( 'sf-menus-admin-css' );
	wp_enqueue_script( 'sf-menus-admin-js', plugins_url('/js/menu-admin.js', __FILE__) , array( 'jquery', 'wp-color-picker' ) , '1.0.0' , true );

	wp_enqueue_style( 'sf-admin-font-awesome', plugins_url('/css/fa.min.css', __FILE__) );
	// Load web font
	wp_register_style('lato-font', '//fonts.googleapis.com/css?family=Lato:300,400,600' );
	wp_enqueue_style( 'lato-font' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_media();

	$sf_menu_data = sf_get_menus_data();

	wp_localize_script( 'sf-menus-admin-js' , 'sf_menus_data' , $sf_menu_data );
	wp_localize_script( 'sf-menus-admin-js' , 'sf_menus_meta' , array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	) );
}


add_action( 'wp_ajax_sf_save_item', 'sf_save_item_fn' );

function sf_save_item_fn() {
	global $wpdb;

	$menu_item_id = $_POST['id'];

	$serialized_settings = $_POST['settings'];

	$result = update_post_meta( $menu_item_id, SF_ITEM_META , $serialized_settings );

	$response = array();

//	$response['settings'] = $settings;
	$response['settings'] = $serialized_settings;
	$response['menu_item_id'] = $menu_item_id;
	$response['meta'] = $result;

	//send back nonce

	//print_r( $response );
	echo json_encode( $response );

	//echo $data;

	die(); // this is required to return a proper result
}

function register_sf_widget_area(){

	if( function_exists( 'register_sidebar' ) ) {
		register_sidebar( array(
			'name' => 'Superfly Widget Area',
			'id' => 'sf_sidebar_widget_area',
			'description' => __( 'Widgets in this area will be shown in Superfly sidebar under the menu', 'superfly-menu' ),
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<h1 class="title">',
			'after_title' => '</h1>',
		) );
	}

}

add_action( 'wp_loaded', 'register_sf_widget_area' );

function sf_get_menus_data ( $menu_id = -1 ){

	if( $menu_id == -1 ){
		global $nav_menu_selected_id;
		$menu_id = $nav_menu_selected_id;
	}

	if( $menu_id == 0 ) return array();

	$sf_menus_data = array();
	$menu_items = wp_get_nav_menu_items( $menu_id, array( 'post_status' => 'any' ) );

	if (is_array($menu_items)) {
		foreach( $menu_items as $item ){
			$_item_settings = sf_get_menu_item_data( $item->ID );
			if( $_item_settings != '' ){
				$sf_menus_data[$item->ID] = $_item_settings;
			}
		}
	}

	//shiftp( $sf_menus_data );
	return $sf_menus_data;
}

function sf_get_menu_item_data( $item_id ){
	$meta = get_post_meta( $item_id , SF_ITEM_META , true );

	//Add URL for image
	if( !empty( $meta['item_image'] ) ){
		$src = wp_get_attachment_image_src( $meta['item_image'] );
		if( $src ){
			$meta['item_image_url'] = $src[0];
			$meta['item_image_edit'] = get_edit_post_link( $meta['item_image'], 'raw' );
		}
	}

	return $meta;
}

/**
 * Settings page in the WP Admin
 */
function sf_page() {

	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.', 'superfly-menu' ) );
	}
	wp_enqueue_script("jquery");
	wp_enqueue_script( 'sf_admin', plugins_url('/js/admin.js', __FILE__) );
	wp_enqueue_script( 'tinycolor', plugins_url('/js/tinycolor.js', __FILE__) );
	wp_enqueue_script( 'sf_colorpickersliders', plugins_url('/js/jquery.colorpickersliders.js', __FILE__) );

	wp_register_style('colorpickersliders-ui-css', plugins_url('/css/jquery.colorpickersliders.css', __FILE__));
	wp_enqueue_style( 'colorpickersliders-ui-css' );

	// Load web font
	wp_register_style('lato-font', '//fonts.googleapis.com/css?family=Lato:300,400' );
	wp_enqueue_style( 'lato-font' );

	wp_register_style('sf-admin-css', plugins_url('/css/admin.css', __FILE__));
	wp_enqueue_style( 'sf-admin-css' );

	include_once(dirname(__FILE__) . '/options-page.php');
}


add_filter('plugin_action_links_superfly-menu/main.php', 'sf_plugin_action_links', 10, 1);

function sf_plugin_action_links($links) {
	$settings_page = add_query_arg(array('page' => 'superfly-menu-options'), admin_url('options-general.php'));
	$settings_link = '<a href="'.esc_url($settings_page).'">'.__('Settings', 'sf' ).'</a>';
	array_unshift($links, $settings_link);
	return $links;
}

add_action('wp_head', 'sf_dynamic_styles', 10);
add_action('wp_footer', 'sf_main_html', 10);

//add_filter( 'wp_nav_menu_items', 'sf_nav_class', 10, 2 );


function sf_nav_class( $items, $args ) {
	$options = sf_get_options();
	if ($options['sf_test_mode'] === 'yes' && !current_user_can( 'manage_options' ) ) return $items;

	if($args -> theme_location == $options['sf_active_menu'] ) {
		$items = '<div id="sf-def-wrapper">' . '<li id="sf-marker">' . $options['sf_active_menu'] . '</li>' . $items . '</div>';
	}

	return $items;
}

function sf_main_html() {
	global $sf_show;
	global $sf_menu_data;

	$options = sf_get_options();
	if ($options['sf_test_mode'] === 'yes' && !current_user_can( 'manage_options' ) ) return;

	if (isset($sf_show) && $sf_show) {

		include_once(dirname(__FILE__) . '/superfly-menu.php');
	}
}

function sf_dynamic_styles() {
	global $sf_show;
	global $sf_menu_data;

	$options = sf_get_options();
	if ($options['sf_test_mode'] === 'yes' && !current_user_can( 'manage_options' ) ) return;

	if (isset($sf_show) && $sf_show) {

		include_once(dirname(__FILE__) . '/superfly-dynamic-styles.php');
	}
}

function sf_scripts() {
	global $sf_show;
	global $sf_menu_data;

	$options = sf_get_options();
	if ($options['sf_test_mode'] === 'yes' && !current_user_can( 'manage_options' ) ) return;

	$post_id = get_queried_object_id();
	$ismobile = wp_is_mobile();
//	$ismobile = sf_is_mobile();
	$sf_show = sf_check_display_rule(json_decode($options['sf_display']), $ismobile, $post_id);

	//sf_debug_to_console($sf_show);

	if ($sf_show) {

		wp_enqueue_script(
			'sf_main',
//			plugins_url('/js/superfly-menu.js', __FILE__),
			 plugins_url('/js/superfly-menu.min.js', __FILE__),
			array('jquery')
		);

		$social = array();
		if (!empty($options['sf_facebook'])) $social['facebook'] = $options['sf_facebook'];
		if (!empty($options['sf_twitter'])) $social['twitter'] = $options['sf_twitter'];
		if (!empty($options['sf_instagram'])) $social['instagram'] = $options['sf_instagram'];
		if (!empty($options['sf_pinterest'])) $social['pinterest'] = $options['sf_pinterest'];
		if (!empty($options['sf_gplus'])) $social['gplus'] = $options['sf_gplus'];

		$sf_menu_data = sf_get_menus_data($options['sf_active_menu']);

		wp_localize_script( 'sf_main', 'SF_Opts', array(
				'social' => $social,
				'search' => $options['sf_search'],
				'blur' => $options['sf_blur_content'],
				'fade' => $options['sf_transition'],
				'test_mode' => $options['sf_test_mode'],
				'hide_def' => $options['sf_hide_def'],
				'mob_nav' => $options['sf_mob_nav'],
				'sidebar_style' => $options['sf_sidebar_style'],
				'sub_animation_type' => $options['sf_sub_push_content'],
				'alt_menu' => $options['sf_alternative_menu'],
				'sidebar_pos' => $options['sf_sidebar_pos'],
				'width_panel_1' => $options['sf_width_panel_1'],
				'width_panel_2' => $options['sf_width_panel_2'],
				'width_panel_3' => $options['sf_width_panel_3'],
				'width_panel_4' => $options['sf_width_panel_4'],
				'base_color' => $options['sf_bg_color_panel_1'],
				'opening_type' => $options['sf_opening_type'],
				'sub_type' => $options['sf_sub_type'],
				'sub_opening_type' => $options['sf_sub_opening_type'],
				'label' => $options['sf_label_style'],
				'label_top' => $options['sf_label_top'],
				'label_size' => $options['sf_label_size'],
				'label_vis' => $options['sf_label_vis'],
				'item_padding' => $options['sf_padding'],
				'bg' => $options['sf_image_bg'],
				'path' => plugins_url('/img/', __FILE__),
				'menu' => $options['sf_active_menu'],
				'togglers' => $options['sf_togglers'],
				'subMenuSupport' => ($ismobile && $options['sf_submenu_mob'] === 'no' ? false : $options['sf_submenu_support']),
				'subMenuSelector' => $options['sf_submenu_classes'],
				'activeClassSelector' => 'current-menu-item',
				'allowedTags' => 'DIV, NAV, UL, OL, LI, A, P, H1, H2, H3, H4, SPAN',
				'menuData' => $sf_menu_data,
                'siteBase' => site_url(),
			  'plugin_ver' => SF_VERSION_NUM
	    )
		);

		if ($options['sf_font'] != 'inherit') {
			if ($options['sf_font'] == 'sans') {
				wp_register_style('sf-open-sans-font', '//fonts.googleapis.com/css?family=Open+Sans' );
				wp_enqueue_style( 'sf-open-sans-font' );
			}
			else if ($options['sf_font'] == 'roboto') {
				wp_register_style('sf-roboto-slab-font', '//fonts.googleapis.com/css?family=Roboto+Slab' );
				wp_enqueue_style( 'sf-roboto-slab-font' );
			}
			else if ($options['sf_font'] == 'lato') {
				wp_register_style('sf-lato-font', '//fonts.googleapis.com/css?family=Lato' );
				wp_enqueue_style( 'sf-lato-font' );
			}
			else if ($options['sf_font'] == 'ubuntu') {
				wp_register_style('sf-ubuntu-font', '//fonts.googleapis.com/css?family=Ubuntu' );
				wp_enqueue_style( 'sf-ubuntu-font' );
			}
		}

		wp_register_style( 'sf_styles', plugins_url('/css/superfly-menu.css', __FILE__) );
		wp_enqueue_style( 'sf_styles' );
	}
}

function sf_is_mobile() {
	return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function sf_get_lang_id($id, $type = 'page') {
	if ( function_exists('icl_object_id') ) {
		$id = icl_object_id($id, $type, true);
	}

	return $id;
}

function sf_check_location ($opt, $post_id) {
	if ( is_home() ) {

		//browser()->log  ( 'home' );

		$show = isset($opt->location->wp_pages->home);
		if ( !$show && $post_id ){
			$show = isset($opt->location->pages->$post_id);
		}

		// check if blog page is front page too
		if ( !$show && is_front_page() /*&& isset($opt['page-front'])*/ ) {
			//browser()->log  ( 'home front' );
			$show = isset($opt->location->wp_pages->front);
		}

	} else if ( is_front_page() ) {
		//browser()->log  ( 'front' );

		$show = isset($opt->location->wp_pages->front);
		if ( !$show && $post_id ) {
			$show = isset($opt->location->pages->$post_id);
		}
	} else if ( is_category() ) {
		//browser()->log  ( 'cat' );
		//browser()->log  ( get_query_var('cat') );
		$catid = get_query_var('cat');
		$show = isset($opt->location->cats->$catid);
	} /*else if ( is_tax() ) {
				$term = get_queried_object();
				$tax = $term->taxonomy;
				$show = isset($opt->location->cats->$tax);
				unset($term);
				unset($tax);
			} else if ( is_post_type_archive() ) {
				$type = get_post_type();
				$show = isset($opt['type-'. $type .'-archive']) ? $opt['type-'. $type .'-archive'] : false;
			}*/ else if ( is_archive() ) {
		//browser()->log  ( 'archive' );

		$show = isset($opt->location->wp_pages->archive);
	} else if ( is_single() ) {
		//browser()->log  ( 'single' );

		$type = get_post_type();
		$show = isset($opt->location->wp_pages->single);

		if ( !$show  && $type != 'page' && $type != 'post') {
			$show = isset($opt->location->cposts->$type);
		}

		if ( !$show ) {
			$cats = get_the_category();
			foreach ( $cats as $cat ) {
				if ($show) break;
				$c_id = sf_get_lang_id($cat->cat_ID, 'category');
				$show = isset($opt->location->cats->$c_id);
				unset($c_id);
				unset($cat);
			}
		}

	} else if ( is_404() ) {
		$show = isset($opt->location->wp_pages->forbidden);
		//browser()->log  ( '404' );
		//browser()->log  ( isset($opt->location->wp_pages->forbidden));

	} else if ( is_search() ) {
		//browser()->log  ( 'search' );

		$show = isset($opt->location->wp_pages->search);
	} else if ( $post_id ) {
		//browser()->log  ( 'post id' );

		$show = isset($opt->location->pages->$post_id);
	} else {
		//browser()->log  ( 'super else' );

		$show = false;
	}

	if ( $post_id && !$show && isset($opt->location->ids) && !empty($opt->location->ids) ) {
		//browser()->log  ( 'ids' );

		$other_ids = $opt->location->ids;
		foreach ( $other_ids as $other_id ) {
			if ( $post_id == (int) $other_id ) {
				$show = true;
			}
		}
	}

	if ( !$show && defined('ICL_LANGUAGE_CODE') ) {
		// check for WPML widgets
		$show = isset($opt->location->langs->ICL_LANGUAGE_CODE);
	}


	if ( !isset($show) ) {
		//browser()->log  ( '!isset($show)' );
		$show = false;
	}

	return $show;
}

function sf_check_display_rule($opt, $isMobile, $post_id) {

//	browser()->log  ( $opt );
//	browser()->log($isMobile);

	$show = sf_check_location($opt, $post_id);

	//browser()->log  ( '>>>> inclusion' );
	//browser()->log  ( $show );

	if ($show && $opt->rule->exclude || !$show && $opt->rule->include ) {
		$show = false;
	} else  {
		$show = true;
	}

	$user_ID = is_user_logged_in();
	//browser()->log  ( '>>>> loggedin' );
	//browser()->log  ( $user_ID );
	//browser()->log  ( '>>>> checked' );
	//browser()->log  ( $show );

	if ( ( $opt->user->loggedout && $user_ID ) || ( $opt->user->loggedin && !$user_ID ) ) {
		$show = false;
	}

	if ( $opt->mobile->no && $isMobile) {
		$show = false;
	}

	if ( $opt->desktop->no && !$isMobile) {
		$show = false;
	}

	return $show;
}

function sf_debug_to_console($data) {
	if(is_array($data) || is_object($data))
	{
		echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
	} else {
		echo("<script>console.log('PHP: ".$data."');</script>");
	}
}

function sf_deparam($query) {
	$map = array();

	if (!empty($query)) {
		$pairs = explode('&', $query);
		$len = sizeof($pairs);
		for ($i = 0; $i < $len; $i += 1) {
			$keyValuePair = explode('=', $pairs[$i]);
			$key = $keyValuePair[0];
			$value = (sizeof($keyValuePair) > 1) ? $keyValuePair[1] : null;
			$map[$key] = $value;
		}
	}
	return $map;
}