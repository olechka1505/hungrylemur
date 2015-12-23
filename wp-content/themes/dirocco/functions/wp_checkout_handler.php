<?php

require_once (get_template_directory() . '/lib/autoload.php');

class WP_Checkout_handler
{
    public $ajaxUrl             = false;
    public $ajaxPrefix          = false;
    private $braintree_config   = false;
    private $clientToken        = false;
    
    
    function __construct()
    {
        $this->ajaxUrl = admin_url('admin-ajax.php');
        $this->ajaxPrefix = 'wp_checkout_';
        $this->braintree_config = get_option('woocommerce_braintree_credit_card_settings');
        
        $environment = $this->braintree_config['environment'];
        $public_key = $environment == 'sandbox' ? $this->braintree_config['sandbox_public_key']: $this->braintree_config['public_key'];
        $private_key = $environment == 'sandbox' ? $this->braintree_config['sandbox_private_key']: $this->braintree_config['private_key'];
        $merchant_id = $environment == 'sandbox' ? $this->braintree_config['sandbox_merchant_id']: $this->braintree_config['merchant_id'];
        
        //Braintree_Configuration::environment('sandbox');
        //Braintree_Configuration::merchantId('38ghysq4hy6wvmhg');
        //Braintree_Configuration::publicKey('6gp2br32grcb3g8t');
        //Braintree_Configuration::privateKey('5b376992e5287b987b0a191b2184e4c4');
        
        Braintree_Configuration::environment($environment);
        Braintree_Configuration::merchantId($merchant_id);
        Braintree_Configuration::publicKey($public_key);
        Braintree_Configuration::privateKey($private_key);
        $this->clientToken = Braintree_ClientToken::generate();

        // Actions
        add_action('wp_enqueue_scripts', array($this, 'add_scripts'));
        add_action($this->ajax_full_action('billing'), array($this, 'billing'));
        add_action($this->ajax_full_action_nopriv('billing'), array($this, 'billing'));
        add_action($this->ajax_full_action('details'), array($this, 'details'));
        add_action($this->ajax_full_action_nopriv('details'), array($this, 'details'));
        add_action($this->ajax_full_action('login'), array($this, 'login'));
        add_action($this->ajax_full_action_nopriv('login'), array($this, 'login'));
        add_action($this->ajax_full_action('signup'), array($this, 'signup'));
        add_action($this->ajax_full_action_nopriv('signup'), array($this, 'signup'));
        add_action($this->ajax_full_action('guest'), array($this, 'guest'));
        add_action($this->ajax_full_action_nopriv('guest'), array($this, 'guest'));
        add_action($this->ajax_full_action('payment'), array($this, 'payment'));
        add_action($this->ajax_full_action_nopriv('payment'), array($this, 'payment'));
        add_action($this->ajax_full_action('confirm'), array($this, 'confirm'));
        add_action($this->ajax_full_action_nopriv('confirm'), array($this, 'confirm'));
        add_action($this->ajax_full_action('promo'), array($this, 'promo'));
        add_action($this->ajax_full_action_nopriv('promo'), array($this, 'promo'));
    }

    function details()
    {
        // if user is not logged in
        $this->check_permissions();
        global $current_user;
        if ($delivery = $this->data('deliveryData')) {
            if ($this->guest_data()) {
                $this->set_guest_data('checkout_delivery', $delivery);
                $response['status'] = true;
            } else {
                $response['status'] = update_user_meta( $current_user->ID, "checkout_delivery", $delivery );
            }
        } else {
            // get billing details
            $response['billing'] = $this->get_billing_details();
            // get shipping details
            $response['shipping'] = $this->get_shipping_details();
        }
        $this->response($response);
    }

    function billing()
    {
        // if user is not logged in
        $this->check_permissions();
        $response = array(
            'status'  => true,
            'invalid' => array(
                'billing' => array(),
                'shipping' => array(),
            ),
        );
        global $current_user;
        $billing = $this->data('billingData');
        $shipping = $this->data('shippingData');
        if ($billing) {
            // validation billing
            foreach ($billing as $key => $item) {
                if (empty($item)) {
                    $response['status'] = false;
                    $response['invalid']['billing'][] = $key;
                }
            }
            if (!$billing['asShippingAddress']) {
                // validation shipping
                foreach ($shipping as $key => $item) {
                    if (empty($item)) {
                        $response['status'] = false;
                        $response['invalid']['shipping'][] = $key;
                    }
                }
            }

            $shipping = $billing['asShippingAddress'] ? $billing: $shipping;
            if ($response['status']) {
                if ($guest_data = $this->guest_data()) {
                    $billing['country'] = 'US';
                    $shipping['country'] = 'US';
                    
                    $billing['email'] = $guest_data['email'];
                    $shipping['email'] = $guest_data['email'];
                    
                    $this->set_guest_data('billing', $billing);
                    $this->set_guest_data('shipping', $shipping);
                } else {
                    // update billing info
                    update_user_meta( $current_user->ID, "billing_first_name", $billing['first_name'] );
                    update_user_meta( $current_user->ID, "billing_last_name", $billing['last_name'] );
                    update_user_meta( $current_user->ID, "billing_company", $billing['company'] );
                    update_user_meta( $current_user->ID, "billing_address_1", $billing['address_1'] );
                    update_user_meta( $current_user->ID, "billing_postcode", $billing['postcode'] );
                    update_user_meta( $current_user->ID, "billing_phone", $billing['phone'] );
                    update_user_meta( $current_user->ID, "billing_suite", $billing['suite'] );
                    update_user_meta( $current_user->ID, "billing_city", $billing['city'] );
                    update_user_meta( $current_user->ID, "billing_state", $billing['state'] );
                    update_user_meta( $current_user->ID, "billing_country", $billing['country'] );
                    update_user_meta( $current_user->ID, "billing_email", $current_user->user_email );

                    // update shipping info
                    update_user_meta( $current_user->ID, "shipping_first_name", $shipping['first_name'] );
                    update_user_meta( $current_user->ID, "shipping_last_name", $shipping['last_name'] );
                    update_user_meta( $current_user->ID, "shipping_company", $shipping['company'] );
                    update_user_meta( $current_user->ID, "shipping_address_1", $shipping['address_1'] );
                    update_user_meta( $current_user->ID, "shipping_postcode", $shipping['postcode'] );
                    update_user_meta( $current_user->ID, "shipping_phone", $shipping['phone'] );
                    update_user_meta( $current_user->ID, "shipping_suite", $shipping['suite'] );
                    update_user_meta( $current_user->ID, "shipping_state", $shipping['state'] );
                    update_user_meta( $current_user->ID, "shipping_city", $shipping['city'] );
                    update_user_meta( $current_user->ID, "shipping_country", $shipping['country'] );
                    update_user_meta( $current_user->ID, "shipping_email", $current_user->user_email );
                }
            }
        }
        // get billing details
        $response['billing'] = $this->get_billing_details();
        // get shipping details
        $response['shipping'] = $this->get_shipping_details();
        $this->response($response);
    }

    function login()
    {
        if ($login = $this->data('loginData')) {
            $response = array('status' => true);
            $statusCode = 200;
            $user = wp_signon(array(
                'user_login'    => $login['login'],
                'user_password' => $login['password'],
            ), false);
            if (is_wp_error($user)) {
                $response['status'] = false;
                $response['errors'][] = $user->get_error_message();
                $statusCode = 500;
            }                     
        }
        $this->response($response, $statusCode);
    }
    
    function promo()
    {
        global $woocommerce;
        
        if ($promo = $this->data('promo')) {
            $response = array('status' => false);
            $statusCode = 200;
            
            if (!$woocommerce->cart->add_discount( sanitize_text_field( $promo ))) {
                $response['status'] = false;
                $response['errors'][] = __('Invalid promo code.');
                $statusCode = 500;
            }
                
            
            /*$coupons = $woocommerce->cart->get_coupons() ;                   
            foreach ($coupons as $coupon) {
                if ($post = get_post($coupon->id)) {
                    if ($promo == $coupon->code) {
                        $this->set_current_promo_id($coupon->id);
                        $response['status'] = true;
                        $statusCode = 200;
                        break;
                    }
                }
            }*/
        }
        $this->response($response, $statusCode);
    }

    function payment()
    {
        global $current_user, $woocommerce;
        $response = array('status' => true);
        
        $statusCode = 200;
        if ($nonce = $this->data('nonce')) {
            $billing = $this->get_billing_details();
            
            // create new user if not exist
            if (!$braintree_user_id = $this->get_braintree_user_id()) {
                $result = Braintree_Customer::create([
                    'firstName'             => $billing['first_name'],
                    'lastName'              => $billing['last_name'],
                    'company'               => $billing['company'],
                    'phone'                 => $billing['phone'],
                    'email'                 => $billing['email'],
                ]);
                if ($guest = $this->guest_data()) {
                    $this->set_guest_data('braintree_customer_id', $result->customer->id);
                } else {
                    update_user_meta( $current_user->ID, "braintree_customer_id", $result->customer->id );
                }
            }
            
            // create credit card
            $result = Braintree_PaymentMethod::create([
                'customerId' => $braintree_user_id,
                'paymentMethodNonce' => $nonce,
            ]);
            
            if ($result->success) {
                
                // create order
                $products = $woocommerce->cart->get_cart();
                $order = wc_create_order();
                foreach ($products as $product) {
                    $order->add_product(get_product($product['product_id']), 1);
                }

                $order->set_address( $this->get_billing_details(), 'billing' );
                $order->set_address( $this->get_shipping_details(), 'shipping' );
                $order->calculate_totals();

                $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
                $current_gateway = 'braintree_credit_card';

                update_post_meta( $order->id, '_payment_method', $current_gateway );
                update_post_meta( $order->id, '_payment_method_title', $current_gateway );

                WC()->session->order_awaiting_payment = $order->id;
                
                $result = Braintree_Transaction::sale([
                    'amount' => $woocommerce->cart->total,
                    'paymentMethodNonce' => $nonce,
                    'options' => [
                      'submitForSettlement' => true,
                    ]
                ]);
                
                if ($result->success) {
                    $order = new WC_Order($order->id);
                    $order->update_status('completed');
                    $response['status'] = true;
                    $statusCode = 200;
                } else {
                    $response['status'] = true;
                    $response['errors'][] = __('Unsuccessfully.');
                    $statusCode = 200;
                }
                //$result = $available_gateways[$current_gateway]->process_payment( $order->id );
            } else {
                $response['status'] = false;
                $response['errors'][] = __('Invalid card info.');
                $statusCode = 500;
            }
        }
        
        $this->response($response, $statusCode);
    }

    function confirm()
    {
        global $woocommerce;
        $products = $woocommerce->cart->get_cart();
        if ($payment = $this->data('confirmData')) {
            $response = array('status' => true);
            $statusCode = 200;
            $order = wc_create_order();
            foreach ($products as $product) {
                $order->add_product(get_product($product['product_id']), 1);
            }

            $order->set_address( $this->get_billing_details(), 'billing' );
            $order->set_address( $this->get_shipping_details(), 'shipping' );
            $order->calculate_totals();

            $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
            $current_gateway = 'braintree_credit_card';

            update_post_meta( $order->id, '_payment_method', $current_gateway );
            update_post_meta( $order->id, '_payment_method_title', $current_gateway );

            WC()->session->order_awaiting_payment = $order->id;
            $result = $available_gateways[$current_gateway]->process_payment( $order->id );

        } else {
            if (!empty($products)) {
                foreach ($products as $product) {
                    $_tax = new WC_Tax();
                    $rates = $_tax->get_rates($product['data']->get_tax_class());
                    $response['products'][] = array(
                        'id'        => $product['product_id'],
                        'name'      => $product['data']->post->post_name,
                        'image'     => wp_get_attachment_url(get_post_thumbnail_id($product['product_id'])),
                        'price'     => $product['data']->price,
                    );
                }
                $response['shipping'] = $this->get_delivery();
                $response['tax'] = !empty($rates) ? $rates[0]: 0;
            } else {
                $response['status'] = false;
                $response['errors'][] = __('No products.');
                $statusCode = 500;
            }

        }
        $this->response($response, $statusCode);
    }

    function guest()
    {
        if ($guest = $this->data('guestData')) {

            $response = array('status' => true);
            $statusCode = 200;

            if (!is_email($guest['email'])) {
                $response['status'] = false;
                $response['errors'][] = __('Invalid email address.');
                $statusCode = 500;
            }

            if ($response['status']) {
                $_SESSION['checkout_as_guest'] = array(
                    'status'    => true,
                    'email'     => $guest['email'],
                );
            }

        }
        $this->response($response, $statusCode);
    }
    
    function signup()
    {
        if ($signup = $this->data('signupData')) {
            $response['status'] = true;
            // Validation
            if (empty($signup['login'])) {
                $response['status'] = false;
                $response['errors'][] = __("User email can't be blank.");
                $statusCode = 500;
            } 
            if (empty($signup['password']) || empty($signup['confirmPassword'])) {
                $response['status'] = false;
                $response['errors'][] = __("Password can't be blank.");
                $statusCode = 500;
            }
            
            if (!is_email($signup['login'])) {
                $response['status'] = false;
                $response['errors'][] = __('Invalid email address.');
                $statusCode = 500;
            }
            
            if ($user_id = username_exists($signup['login']) || email_exists($signup['login'])) {
                $response['status'] = false;
                $response['errors'][] = __('This user is already exist.');
                $statusCode = 500;
            }
            if ($signup['confirmPassword'] != $signup['password']) {
                $response['status'] = false;
                $response['errors'][] = __('Please confirm your password.');
                $statusCode = 500;
            } 
            // create user and logged in
            if ($response['status']) {
                $user_id = wp_create_user( $signup['login'], $signup['password'], $signup['login'] );
                $user = wp_signon(array(
                    'user_login'    => $signup['login'],
                    'user_password' => $signup['password'],
                ), false);
                if (is_wp_error($user)) {
                    $response['status'] = false;
                    $response['errors'][] = __('Invalid email or password.');
                    $statusCode = 500;
                } else {
                    $response['status'] = true;
                    $statusCode = 200;
                }
            }
        } else {
            $response['status'] = false;
            $response['errors'][] = __("Please fill all fields.");
            $statusCode = 500;
        }
        $this->response($response, $statusCode);
    }

    function get_billing_details()
    {
        global $current_user;
        if ($data = $this->guest_data()) {
            $response['billing'] = $data['billing'];
        } else {
            $response['billing']['first_name'] = get_user_meta( $current_user->ID, 'billing_first_name', true );
            $response['billing']['last_name'] = get_user_meta( $current_user->ID, 'billing_last_name', true );
            $response['billing']['company'] = get_user_meta( $current_user->ID, 'billing_company', true );
            $response['billing']['address_1'] = get_user_meta( $current_user->ID, 'billing_address_1', true );
            $response['billing']['postcode'] = get_user_meta( $current_user->ID, 'billing_postcode', true );
            $response['billing']['phone'] = get_user_meta( $current_user->ID, 'billing_phone', true );
            $response['billing']['suite'] = get_user_meta( $current_user->ID, 'billing_suite', true );
            $response['billing']['city'] = get_user_meta( $current_user->ID, 'billing_city', true );
            $response['billing']['state'] = get_user_meta( $current_user->ID, 'billing_state', true );
            $response['billing']['country'] = get_user_meta( $current_user->ID, 'country', true );
            $response['billing']['email'] = get_user_meta( $current_user->ID, 'billing_email', true );
        }
        return $response['billing'];
    }

    function get_shipping_details()
    {
        global $current_user;
        if ($data = $this->guest_data()) {
            $response['shipping'] = $data['shipping'];
        } else {
            $response['shipping']['first_name'] = get_user_meta( $current_user->ID, 'shipping_first_name', true );
            $response['shipping']['last_name'] = get_user_meta( $current_user->ID, 'shipping_last_name', true );
            $response['shipping']['company'] = get_user_meta( $current_user->ID, 'shipping_company', true );
            $response['shipping']['address_1'] = get_user_meta( $current_user->ID, 'shipping_address_1', true );
            $response['shipping']['postcode'] = get_user_meta( $current_user->ID, 'shipping_postcode', true );
            $response['shipping']['suite'] = get_user_meta( $current_user->ID, 'shipping_suite', true );
            $response['shipping']['city'] = get_user_meta( $current_user->ID, 'shipping_city', true );
            $response['shipping']['state'] = get_user_meta( $current_user->ID, 'shipping_state', true );
            $response['shipping']['country'] = get_user_meta( $current_user->ID, 'country', true );
            $response['shipping']['email'] = get_user_meta( $current_user->ID, 'shipping_email', true );
        }
        return $response['shipping'];
    }

    function ajax_full_action($action)
    {
        return 'wp_ajax_' . $this->ajaxPrefix . $action;
    }

    function ajax_full_action_nopriv($action)
    {
        return 'wp_ajax_nopriv_' . $this->ajaxPrefix . $action;
    }

    function add_scripts()
    {
        // load scripts
        wp_enqueue_script('angular.core', get_template_directory_uri() . '/js/wp_checkout_handler/core/angular.min.js', array('jquery'));
        wp_enqueue_script('angular.choosen', get_template_directory_uri() . '/js/wp_checkout_handler/core/angular-chosen.min.js', array('angular.core'));
        wp_enqueue_script('angular.ui.router', get_template_directory_uri() . '/js/wp_checkout_handler/core/angular-ui-router.min.js', array('angular.choosen'));
        wp_enqueue_script('angular.sanitize', get_template_directory_uri() . '/js/wp_checkout_handler/core/angular-sanitize.min.js', array('angular.ui.router'));
        wp_enqueue_script('angular.bootstrap', get_template_directory_uri() . '/js/wp_checkout_handler/core/ui-bootstrap-tpls-0.14.3.min.js', array('angular.sanitize'));
        wp_enqueue_script('angular.module.checkout', get_template_directory_uri() . '/js/wp_checkout_handler/modules/checkout.module.js', array('angular.bootstrap'));
        wp_enqueue_script('angular.service.checkout', get_template_directory_uri() . '/js/wp_checkout_handler/services/checkout.js', array('angular.module.checkout'));
        wp_enqueue_script('angular.controller.checkout', get_template_directory_uri() . '/js/wp_checkout_handler/controllers/checkout.controller.js', array('angular.service.checkout'));
        wp_enqueue_script('angular.config.checkout', get_template_directory_uri() . '/js/wp_checkout_handler/config/checkout.config.js', array('angular.controller.checkout'));
        // load stylesheets
        wp_enqueue_style('checkout.css', get_template_directory_uri() . '/css/wp_checkout_handler/checkout.css');
        $wc_country = new WC_Countries();
        $states = $wc_country->get_states('US');
        //some variables to scripts
        wp_localize_script('angular.service.checkout', 'ajaxUrl', $this->ajaxUrl);
        wp_localize_script('angular.service.checkout', 'ajaxPrefix', $this->ajaxPrefix);
        wp_localize_script('angular.controller.checkout', 'states', $states);
        wp_localize_script('angular.controller.checkout', 'clientToken', $this->clientToken);
    }

    public function response($data, $status = 200)
    {
        header("Content-Type: application/json");
        header("HTTP/1.1 " . $status . " " . $this->__requestStatus($status));
        echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        die;
    }

    private function __requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code])?$status[$code]:$status[500];
    }

    public function data($key = false)
    {
        if (isset($_POST['data'])) {
            if ($data = json_decode(stripslashes($_POST['data']), TRUE)) {
                return $data[$key];
            }
        }
        return false;
    }

    function check_permissions()
    {
        if (!is_user_logged_in() && !$this->guest_data()) {
            $this->response(array(
                'message' => 'Forbidden',
            ), 403);
        }
    }
    
    function get_braintree_user_id()
    {
        global $current_user;
        if ($data = $this->guest_data()) {
            return isset($data['braintree_customer_id']) ? $data['braintree_customer_id']: false;
        } else {
            return get_user_meta( $current_user->ID, 'braintree_customer_id', true );
        }
    }

    function guest_data()
    {
        return isset($_SESSION['checkout_as_guest']) ? $_SESSION['checkout_as_guest']: false;
    }

    function get_delivery()
    {
        if ($data = $this->guest_data()) {
            return $data['checkout_delivery'];
        } else {
            global $current_user;
            return get_user_meta( $current_user->ID, 'checkout_delivery', true );
        }
    }

    function set_guest_data($key, $data)
    {
        $_SESSION['checkout_as_guest'][$key]= $data;
    }
    
    function get_current_promo_id()
    {
        return isset($_SESSION['current_promo_id']) ? $_SESSION['current_promo_id']: false;
    }
    
    function set_current_promo_id($promo_id)
    {
        $_SESSION['current_promo_id'] = $promo_id;
    }

}
new WP_Checkout_handler();