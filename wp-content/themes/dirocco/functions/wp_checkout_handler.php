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
        add_action($this->ajax_full_action('complete'), array($this, 'complete'));
        add_action($this->ajax_full_action_nopriv('complete'), array($this, 'complete'));
        add_action($this->ajax_full_action('confirmOrder'), array($this, 'confirmOrder'));
        add_action($this->ajax_full_action_nopriv('confirmOrder'), array($this, 'confirmOrder'));
    }

    function details()
    {
        // if user is not logged in
        $this->check_permissions();
        // get billing details
        $response['billing'] = $this->get_billing_details();
        // get shipping details
        $response['shipping'] = $this->get_shipping_details();
        $this->response($response);
    }


    function confirmOrder()
    {
        global $woocommerce;
        // if user is not logged in
        $this->check_permissions();
        $response = array('status' => true);
        $statusCode = 200;
        $response['shipping'] = $this->get_shipping_details();
        $paymentMethod = WC()->session->paymentMethod;
        if ($paymentMethod) {
            $response['card'] = array(
                'type'  => $paymentMethod->cardType,
                'bin'   => $paymentMethod->bin,
                'last4' => $paymentMethod->last4,
            );
        }
        if ($order_id = WC()->session->last_order_id) {
            $order = new WC_Order($order_id);
            $order->calculate_taxes();
            $products = $order->get_items();
            $response['tax'] = 0;
            foreach ($products as $id => $product) {
                $terms = get_the_terms($product['product_id'], 'product_cat');
                $product_cat = array();
                foreach ($terms as $term) {
                    $product_cat[] = $term->name;
                }
                $wc_product = new WC_Product($product['product_id']);
                $response['products'][] = array(
                    'id'                => $product['product_id'],
                    'name'              => $product['name'],
                    'qty'               => $product['qty'],
                    'cat'               => implode(', ', $product_cat),
                    'image'             => wp_get_attachment_url(get_post_thumbnail_id($product['product_id'])),
                    'price'             => $wc_product->price,
                    'price_with_tax'    => $product['line_subtotal'],
                    'tax'               => $product['line_tax'],
                );
                $response['tax'] += $product['line_tax'];
            }
            $response['delivery'] = $this->get_delivery();
            $response['subtotal'] = $woocommerce->cart->get_cart_subtotal();
            $response['total'] = $woocommerce->cart->total;
            $response['total_with_tax'] = floatval($woocommerce->cart->total) + floatval($response['tax']);
            if ($response['delivery']['expedited']) {
                $response['total'] += 40;
            }
            WC()->session->last_order = $response;
        }
        $this->response($response, $statusCode);
    }

    function billing()
    {
        // if user is not logged in
//        unset($_SESSION);
        $this->check_permissions();

        $_billing = $_shipping = array(
            'first_name' => '',
            'last_name' => '',
            'company' => '',
            'address_1' => '',
            'postcode' => '',
            'phone' => '',
            'suite' => '',
            'city' => '',
            'state' => '',
            'country' => 'US',
        );

        $response['status'] = true;
        $statusCode = 200;

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

        $guest = $this->guest_data();
        $billing['country'] = $shipping['country'] = 'US';
        $billing['email'] = $shipping['email'] = is_user_logged_in() ? $current_user->user_email : $guest['email'];

        if ($billing) {
            $billing = array_replace_recursive($_billing, $billing);
            // validation billing
            foreach ($billing as $key => $item) {
                if ($key == 'company' || $key == 'suite') {
                    continue;
                }
                if (empty($item)) {
                    $response['status'] = false;
                    $response['invalid']['billing'][] = $key;
                }
            }
            if (!$billing['asShippingAddress']) {
                // validation shipping
                foreach ($shipping as $key => $item) {
                    if ($key == 'company' || $key == 'suite') {
                        continue;
                    }
                    if (empty($item)) {
                        $response['status'] = false;
                        $response['invalid']['shipping'][] = $key;
                    }
                }
            }

            $shipping = $billing['asShippingAddress'] ? $billing: $shipping;
            $shipping = array_replace_recursive($_shipping, $shipping);
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
        $this->response($response, $statusCode);
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
        }
        $this->response($response, $statusCode);
    }

    function payment()
    {
        global $current_user, $woocommerce;
        $this->check_permissions();
        $response = array('status' => true);
        $statusCode = 200;
        if ($nonce = $this->data('nonce')) {
            if ($delivery = $this->data('deliveryData')) {
                if ($this->guest_data()) {
                    $this->set_guest_data('checkout_delivery', $delivery);
                } else {
                    update_user_meta( $current_user->ID, "checkout_delivery", $delivery ) || add_user_meta( $current_user->ID, "checkout_delivery", $delivery, true );
                }
            }
            
            $billing = $this->get_billing_details();
            $braintree_user_id = $this->get_braintree_user_id();
            try {
                $bt_customer = Braintree_Customer::find($braintree_user_id);
            } catch (Exception $e) {
                delete_user_meta($current_user->ID, "braintree_customer_id");
                $braintree_user_id = $this->get_braintree_user_id();
            }

            // create new user if not exist
            if (!$braintree_user_id) {
                $result = Braintree_Customer::create([
                    'firstName'             => $billing['first_name'],
                    'lastName'              => $billing['last_name'],
                    'company'               => $billing['company'],
                    'phone'                 => $billing['phone'],
                    'email'                 => $billing['email'],
                ]);
                if ($result->success) {
                    if ($guest = $this->guest_data()) {
                        $this->set_guest_data('braintree_customer_id', $result->customer->id);
                        $braintree_user_id = $this->get_braintree_user_id();
                    } else {
                        update_user_meta( $current_user->ID, "braintree_customer_id", $result->customer->id );
                    }
                } else {
                    $response['status'] = true;
                    $response['errors'][] = __("Customer wasn't created.");
                    $statusCode = 500;
                }
            }
            $delivery = $this->get_delivery();
            $total = $woocommerce->cart->total;
            if (isset($delivery['expedited']) && $delivery['expedited']) {
                $total += 40;
            }

            // charge credit card
            $result = Braintree_PaymentMethod::create([
                'customerId' => $braintree_user_id,
                'paymentMethodNonce' => $nonce
            ]);

            if ($result->success) {
                // save payment methodin session
                WC()->session->paymentMethod = $result->paymentMethod;

                // create order
                $products = $woocommerce->cart->get_cart();
                $order = wc_create_order();
                foreach ($products as $product) {
                    $order->add_product(get_product($product['product_id']), $product['quantity']);
                }

                $order->set_address( $this->get_billing_details(), 'billing' );
                $order->set_address( $this->get_shipping_details(), 'shipping' );
                $order->calculate_totals();

                $current_gateway = 'braintree_credit_card';
                update_post_meta( $order->id, '_payment_method', $current_gateway );
                update_post_meta( $order->id, '_payment_method_title', $current_gateway );

                if ($data = $this->guest_data()) {
                    $this->set_guest_data('_braintree_transaction_id', $result->transaction->id);
                } else {
                    update_user_meta( $current_user->ID, '_braintree_transaction_id', $result->transaction->id ) || update_user_meta( $current_user->ID, '_braintree_transaction_id', $result->transaction->id, true );
                }

                WC()->session->last_order_id = $order->id;

                $order->update_status('processing');
                $response['status'] = true;
                $response['order_id'] = $order->id;
                $statusCode = 200;
            } else {
                $response['status'] = false;
                $response['errors'][] = $result->message;
                $statusCode = 500;
            }
        }
        
        $this->response($response, $statusCode);
    }

    function complete()
    {
        global $woocommerce;
        $order = WC()->session->last_order;
        $braintree_user_id = $this->get_braintree_user_id();
        $result = Braintree_Transaction::sale(
            [
                'customerId' => $braintree_user_id,
                'amount' => money_format('%i', $order['total_with_tax'])
            ]
        );

        if ($result->success) {
            $response['shop_url'] = get_permalink( woocommerce_get_page_id( 'shop' ) );
            $response['order_id'] = $result->transaction->id;
            $woocommerce->cart->empty_cart();
            $order = new WC_Order(WC()->session->last_order_id);
            $order->update_status('completed');
            unset(WC()->session->last_transaction);
            unset(WC()->session->paymentMethod);
            unset(WC()->session->last_order_id);
            unset(WC()->session->last_order);
            $statusCode = 200;
        } else {
            $response['status'] = false;
            $response['errors'][] = $result->message;
            $statusCode = 500;
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
//            $response['billing']['country'] = get_user_meta( $current_user->ID, 'country', true );
            $response['billing']['country'] = 'US';
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
//            $response['shipping']['country'] = get_user_meta( $current_user->ID, 'country', true );
            $response['shipping']['country'] = 'US';
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
        global $woocommerce;
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
        wp_localize_script('angular.controller.checkout', 'home_url', home_url());
        wp_localize_script('angular.controller.checkout', 'checkout_url', $woocommerce->cart->get_checkout_url());
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
        return (isset($_SESSION['checkout_as_guest']) && !is_user_logged_in()) ? $_SESSION['checkout_as_guest']: false;
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

    function unset_guest_data()
    {
        unset($_SESSION['checkout_as_guest']);
    }
    
    function get_current_promo_id()
    {
        return isset($_SESSION['current_promo_id']) ? $_SESSION['current_promo_id']: false;
    }
    
    function set_current_promo_id($promo_id)
    {
        $_SESSION['current_promo_id'] = $promo_id;
    }
    function get_transaction_id()
    {
        if ($data = $this->guest_data()) {
            return $data['_braintree_transaction_id'];
        } else {
            global $current_user;
            return get_user_meta( $current_user->ID, '_braintree_transaction_id', true );
        }
    }

}
new WP_Checkout_handler();
