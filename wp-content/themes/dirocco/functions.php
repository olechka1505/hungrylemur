<?php
/**
 * Modality functions and definitions
 *
 * @package Modality
*/

// Use a child theme instead of placing custom functions here
// http://codex.wordpress.org/Child_Themes
/* Enable Session */
if (!session_id()) {
    session_start();
}
/* ------------------------------------------------------------------------- *
 *  Load theme files
/* ------------------------------------------------------------------------- */
require_once ('functions/modality-functions.php'); 			// Theme Custom Functions
require_once ('functions/modality-customizer.php');			// Load Customizer
require_once ('functions/modality-image-sliders.php'); 		// Theme Custom Functions
require_once ('functions/modality-woocommerce.php');		// WooCommerce Support
require_once ('functions/wp_bootstrap_navwalker.php');
require_once ('functions/wp_checkout_handler.php');



/* This is the length of the excerpt -- Used for homepage slider */
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 100 );
function new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');
function get_excerpt($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_content();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  $excerpt = $excerpt.'...';
  return $excerpt;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );      	// Remove the description tab
    unset( $tabs['reviews'] ); 			// Remove the reviews tab
    unset( $tabs['additional_information'] );  	// Remove the additional information tab

    return $tabs;

}
/*
 * wc_remove_related_products
 * 
 * Clear the query arguments for related products so none show.
 * Add this code to your theme functions.php file.  
 */
function wc_remove_related_products( $args ) {
	return array();
}
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10); 

/**
* Update the custom field when the form submits
*
* @param type $post_id
*/
function wpuf_woo_product_gallery( $post_id ) {
    if ( isset( $_POST['wpuf_files']['_product_image'] ) ) {
 
        $images = get_post_meta($post_id, '_product_image' );
        update_post_meta( $post_id, '_product_image_gallery', implode(',', $images) );
    }
}
 
add_action( 'wpuf_add_post_after_insert', 'wpuf_woo_product_gallery' );
add_action( 'wpuf_edit_post_after_update', 'wpuf_woo_product_gallery' );

// Wocommerce
/*
add_filter("woocommerce_checkout_fields", "order_fields");

function order_fields($fields) {

    $order = array(
        "billing_first_name", 
        "billing_last_name", 
        "billing_company", 
        "billing_address_1", 
        "billing_address_2", 
        "billing_postcode", 
        "billing_country", 
        "billing_email", 
        "billing_phone"

    );
    foreach($order as $field)
    {
        $ordered_fields[$field] = $fields["billing"][$field];
    }

    $fields["billing"] = $ordered_fields;
    return $fields;

}

// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
 
// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     unset($fields['billing']['billing_country']); // Country field
	 unset($fields['billing']['billing_email']); // E-mail field
	 unset($fields['shipping']['shipping_country']); // Country field
	 unset($fields['shipping']['shipping_state']); // Country field
	 unset($fields['shipping']['shipping_city']); // 
	 unset($fields['order']['order_comments']); // 
	 
	 
	 $fields['billing']['billing_first_name']['placeholder'] = 'First name';
	 $fields['billing']['billing_last_name']['placeholder'] = 'Last name';
	 $fields['billing']['billing_company']['placeholder'] = 'Company';
	 $fields['billing']['billing_address_1']['placeholder'] = 'Street Address';
	 $fields['billing']['billing_address_2']['placeholder'] = 'Apt/Suite';
	 $fields['billing']['billing_postcode']['label'] = 'Enter for city & State';
	 $fields['billing']['billing_postcode']['placeholder'] = 'Zip code';
	 $fields['billing']['billing_phone']['placeholder'] = 'Phone number';	 
	 $fields['shipping']['shipping_first_name']['placeholder'] = 'First name';
	 $fields['shipping']['shipping_last_name']['placeholder'] = 'Last name';
	 $fields['shipping']['shipping_company']['placeholder'] = 'Company';
	 $fields['shipping']['shipping_address_1']['placeholder'] = 'Street Address';
	 $fields['shipping']['shipping_address_2']['placeholder'] = 'Apt/Suite';
	 $fields['shipping']['shipping_postcode']['label'] = 'Enter for city & State';
	 $fields['shipping']['shipping_postcode']['placeholder'] = 'Zip code';
	 $fields['shipping']['shipping_phone']['placeholder'] = 'Phone number';
	 
     return $fields;
}
*/
/**
 * Add new register fields for WooCommerce registration.
 *
 * @return string Register fields HTML.
 *//*
function wooc_extra_register_fields() {
	?>

	<p class="form-row form-row-first">
	<input type="text" class="input-text" placeholder="First Name" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
	</p>

	<p class="form-row form-row-last">
	<input type="text" class="input-text" placeholder="Last Name" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
	</p>

	<?php
}

add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
*/
/**
 * Validate the extra register fields.
 *
 * @param  string $username          Current username.
 * @param  string $email             Current email.
 * @param  object $validation_errors WP_Error object.
 *
 * @return void
 *//*
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
	if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
		$validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
	}

	if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
		$validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
	}

}

add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );
*/
/**
 * Save the extra register fields.
 *
 * @param  int  $customer_id Current customer ID.
 *
 * @return void
 */
 
 /*
function wooc_save_extra_register_fields( $customer_id ) {
	if ( isset( $_POST['billing_first_name'] ) ) {
		// WordPress default first name field.
		update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );

		// WooCommerce billing first name.
		update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
	}

	if ( isset( $_POST['billing_last_name'] ) ) {
		// WordPress default last name field.
		update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );

		// WooCommerce billing last name.
		update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
	}

}

add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
*/
//Redirect

add_filter('woocommerce_registration_redirect', 'ps_wc_registration_redirect');

function ps_wc_registration_redirect( $redirect_to ) {
     $redirect_to = '/my-account/edit-account/';
     return $redirect_to;
}


// remove Order Notes from checkout field in Woocommerce
add_filter( 'woocommerce_checkout_fields' , 'alter_woocommerce_checkout_fields' );
function alter_woocommerce_checkout_fields( $fields ) {
     unset($fields['order']['order_comments']);
     return $fields;
}

add_filter( 'woocommerce_billing_fields' , 'custom_override_billing_fields' );
add_filter( 'woocommerce_shipping_fields' , 'custom_override_shipping_fields' );

function custom_override_billing_fields( $fields ) {
  /*unset($fields['billing_state']);*/
  unset($fields['billing_country']);
  unset($fields['billing_email']);
  /*unset($fields['billing_city']);*/
  
  $fields['billing_first_name']['placeholder'] = 'First name';
  $fields['billing_last_name']['placeholder'] = 'Last name';
  $fields['billing_company']['placeholder'] = 'Company';
  $fields['billing_address_1']['placeholder'] = 'Street Address';
  $fields['billing_address_2']['placeholder'] = 'Apt/Suite';
  $fields['billing_postcode']['placeholder'] = 'Zip code';
  $fields['billing_city']['placeholder'] = 'City';
  $fields['billing_phone']['placeholder'] = 'Phone number';	 
  return $fields;
}

function custom_override_shipping_fields( $fields ) {
  /*unset($fields['shipping_state']);*/
  unset($fields['shipping_country']);
  unset($fields['shipping_email']);
  /*unset($fields['shipping_city']);*/
  
  $fields['shipping_first_name']['placeholder'] = 'First name';
  $fields['shipping_last_name']['placeholder'] = 'Last name';
  $fields['shipping_company']['placeholder'] = 'Company';
  $fields['shipping_address_1']['placeholder'] = 'Street Address';
  $fields['shipping_address_2']['placeholder'] = 'Apt/Suite';
  $fields['shipping_postcode']['placeholder'] = 'Zip code';
  $fields['shipping_city']['placeholder'] = 'City';
  $fields['shipping_phone']['placeholder'] = 'Phone number';	 
  return $fields;
}

/**/
add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {
    add_image_size( 'category-thumb', 300 ); // 300 pixels wide (and unlimited height)
    add_image_size( 'homepage-thumb', 220, 180, true ); // (cropped)
}
function plugin_registration_redirect() {
    return home_url( '/checkout' );
}
add_filter( 'registration_redirect', 'plugin_registration_redirect' );

// Custom redirect for users after logging in
add_filter('woocommerce_login_redirect', 'bryce_wc_login_redirect');
function bryce_wc_login_redirect( $redirect ) {
     return home_url( '/checkout' );
}

add_filter( 'pre_get_posts', 'custom_add_products_search' );
function custom_add_products_search( $query ) {
    if ( $query->is_search ) {
    $query->set( 'post_type', array( 'post', 'page', 'product'));
    }
    return $query;
}