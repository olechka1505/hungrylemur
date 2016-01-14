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
        add_action($this->ajax_full_action('signin'), array($this, 'signin'));
        add_action($this->ajax_full_action_nopriv('signin'), array($this, 'signin'));
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
        add_action($this->ajax_full_action('updateShipping'), array($this, 'updateShipping'));
        add_action($this->ajax_full_action_nopriv('updateShipping'), array($this, 'updateShipping'));
        add_action('woocommerce_after_cart_table', array($this, 'cart_promo'));
        add_action('woocommerce_before_notices', array($this, 'cart_promo_apply'));

        // Filters
        add_filter( 'woocommerce_coupon_message', array($this, 'filter_woocommerce_coupon_message', 10, 3));
        add_filter( 'default_checkout_country', array($this, 'change_default_checkout_country'));
    }

    function change_default_checkout_country()
    {
        return 'US';
    }

    function filter_woocommerce_coupon_message( $msg, $msg_code, $instance )
    {
        return false;
    }
    
    function cart_promo()
    {
        if ( 'yes' === get_option( 'woocommerce_enable_coupons' ) ) {
            require_once get_template_directory() . "/woocommerce/cart/promo_code.php";
        }
    }
    
    function cart_promo_apply()
    {
        global $woocommerce;
        if (isset($_POST['promo']) && wp_verify_nonce( $_POST['promo_nonce'], 'woocommerce_before_notices' )) {
            $promo = $_POST['promo'];
            if ($woocommerce->cart->has_discount(sanitize_text_field($promo))) {
                $woocommerce->cart->remove_coupons(sanitize_text_field($promo));
                $woocommerce->cart->calculate_totals();
            }
            if ($woocommerce->cart->add_discount( sanitize_text_field( $promo ))) {
                $woocommerce->cart->calculate_totals();
                wc_add_notice('Coupon apllied.');
            }
        }
    }

    function details()
    {
        $shipping_package = WC()->session->shippinng_rates;
        $response['rates_error'] = false;
        if (!empty($shipping_package[0]['rates'])) {
            $response['rates'] = $shipping_package[0]['rates'];
        } else {
            $response['rates_error'] = sprintf(__( 'There are no shipping methods available. Please double <a href="%s">check your address</a>, or contact us if you need any help.', 'woocommerce' ), '/checkout/#/billing');
        }
        $chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );
        $response['chosen_shipping_methods'] = $chosen_shipping_methods[0];
        // if user is not logged in
        $this->check_permissions();
        // get billing details
        $response['billing'] = $this->get_billing_details();
        // get shipping details
        $response['shipping'] = $this->get_shipping_details();
        $this->response($response);
    }

    function updateShipping()
    {
        $response['status'] = true;
        $statusCode = 200;
        if ($rate_id = $this->data('rate_id')) {
            $chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );
            if ( isset( $rate_id ) ) {
                $chosen_shipping_methods = array($rate_id);
            }
            WC()->session->set( 'chosen_shipping_methods', $chosen_shipping_methods );
        } else {
            $response['status'] = false;
            $response['errors'][] = __("Choose shipping method.");
            $statusCode = 500;
        }
        WC()->cart->calculate_totals();
        $this->response($response, $statusCode);
    }


    function confirmOrder()
    {
        global $woocommerce;
        if ($createAccount = $this->data('createAccount')) {
            $response['status'] = true;

            if (empty($createAccount['login']) && empty($createAccount['password'])) {
                $response['status'] = true;
            } else {
                // Validation
                if (!empty($createAccount['login']) && empty($createAccount['password'])) {
                    $response['status'] = false;
                    $response['errors'][] = __("Password can't be blank.");
                    $statusCode = 500;
                }

                if (empty($createAccount['login']) && !empty($createAccount['password'])) {
                    $response['status'] = false;
                    $response['errors'][] = __("Email can't be blank.");
                    $statusCode = 500;
                }

                if (!is_email($createAccount['login'])) {
                    $response['status'] = false;
                    $response['errors'][] = __('Invalid email address.');
                    $statusCode = 500;
                }

                if ($user_id = username_exists($createAccount['login']) || email_exists($createAccount['login'])) {
                    $response['status'] = false;
                    $response['errors'][] = sprintf('This account already exists. Please <a href="%s">sign in</a> here', '/checkout/#/signin');
                    $statusCode = 500;
                }

                // create user and logged in
                if ($response['status']) {
                    $create_user_id = wp_create_user( $createAccount['login'], $createAccount['password'], $createAccount['login'] );
                    if (is_wp_error($create_user_id)) {
                        $response['status'] = false;
                        $response['errors'][] = __('User wan not created.');
                        $statusCode = 500;
                    } else {
                        $billing_data = $this->get_billing_details();
                        $shipping_data = $this->get_shipping_details();

                        foreach ($billing_data as $key=> $item) {
                            update_user_meta( $create_user_id, "billing_{$key}", $item );
                        }
                        foreach ($shipping_data as $key=> $item) {
                            update_user_meta( $create_user_id, "shipping_{$key}", $item );
                        }

                        $response['status'] = true;
                        $statusCode = 200;
                    }
                }
            }
            // create transaction
            if ($response['status']) {
                $order = WC()->session->last_order;
                $braintree_user_id = $this->get_braintree_user_id();
                $result = Braintree_Transaction::sale(
                    [
                        'customerId' => $braintree_user_id,
                        'amount' => money_format('%i', $order['total'])
                    ]
                );
                if ($result->success) {
                    $settlement = Braintree_Transaction::submitForSettlement($result->transaction->id);

                    if ($settlement->success) {
                        $response['shop_url'] = get_permalink( woocommerce_get_page_id( 'shop' ) );
                        $response['order_id'] = $result->transaction->id;
                        $response['order_info'] = $order;
                        $paymentMethod = WC()->session->paymentMethod;
                        if ($paymentMethod) {
                            $response['card'] = array(
                                'type'  => $paymentMethod->cardType,
                                'bin'   => $paymentMethod->bin,
                                'last4' => $paymentMethod->last4,
                            );
                        }
                        $shipping_package = WC()->session->shippinng_rates;
                        $chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );
                        if (!empty($shipping_package[0]['rates'])) {
                            $response['delivery'] = $shipping_package[0]['rates'][$chosen_shipping_methods[0]];
                        }
                        $woocommerce->cart->empty_cart();
                        $order = new WC_Order(WC()->session->last_order_id);
                        $order->update_status('completed');

                        if (is_user_logged_in()) {
                            global $current_user;
                            update_post_meta($order->id, '_customer_user', $current_user->ID);
                        } else if ($create_user_id) {
                            update_post_meta($order->id, '_customer_user', $create_user_id);
                        }

                        unset(WC()->session->last_transaction);
                        unset(WC()->session->paymentMethod);
                        unset(WC()->session->last_order_id);
                        unset(WC()->session->last_order);
                        WC()->session->last_complete = $response;
                        $statusCode = 200;
                    }

                } else {
                    $response['status'] = false;
                    $response['errors'][] = $result->message;
                    $statusCode = 500;
                }
            }

        } else {
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
                }
                WC()->cart->calculate_shipping();
                WC()->cart->calculate_fees();
                $response['show_create_account'] = !is_user_logged_in();
                $response['subtotal'] = WC()->cart->get_cart_subtotal();
                $response['coupons_total'] = $this->get_coupons_total();
                $response['shipping_total'] = WC()->cart->shipping_total;
                $response['tax'] = WC()->cart->tax_total;
                $response['total'] = $this->get_cart_total();
                WC()->session->last_order = $response;
            }
        }
        $this->response($response, $statusCode);
    }

    public function get_cart_total()
    {
        return WC()->cart->cart_contents_total + WC()->cart->shipping_total + WC()->cart->tax_total;
    }

    public function get_coupons_total()
    {
        return array_sum(WC()->cart->coupon_discount_amounts);
    }

    function billing()
    {
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
                if ($key == 'company' || $key == 'suite' || $key == 'asShippingAddress') {
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
                    $billing['email'] = $shipping['email'] = $guest_data['email'];
                    $this->set_guest_data('billing', $billing);
                    $this->set_guest_data('shipping', $shipping);
                } else {
                    $billing['email'] = $shipping['email'] = $current_user->user_email;
                    // update billing info
                    foreach ($billing as $key_billing => $value_biling) {
                       update_user_meta( $current_user->ID, "billing_{$key_billing}", $value_biling ); 
                    }

                    // update shipping info
                    foreach ($billing as $key_shipping => $value_shipping) {
                       update_user_meta( $current_user->ID, "shipping_{$key_shipping}", $value_shipping );
                    }
                }
                $this->set_wc_customer_data();
                WC()->shipping()->calculate_shipping(WC()->cart->get_shipping_packages());
                WC()->session->shippinng_rates = WC()->shipping()->get_packages();
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

    function signin()
    {
        if ($signin = $this->data('signinData')) {
            $response = array('status' => true);
            $statusCode = 200;
            $user = wp_signon(array(
                'user_login'    => $signin['login'],
                'user_password' => $signin['password'],
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
            if ($woocommerce->cart->has_discount(sanitize_text_field($promo))) {
                $woocommerce->cart->remove_coupons(sanitize_text_field($promo));
                $woocommerce->cart->calculate_totals();
            }
            if (!$woocommerce->cart->add_discount( sanitize_text_field( $promo ))) {
                $response['status'] = false;
                $response['errors'][] = __('Invalid promo code.');
                $statusCode = 500;
            } else {
                $woocommerce->cart->calculate_totals();
                $response['status'] = true;
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
            
            $braintree_user_id = $this->get_braintree_user_id();
            try {
                $bt_customer = Braintree_Customer::find($braintree_user_id);
            } catch (Exception $e) {
                delete_user_meta($current_user->ID, "braintree_customer_id");
                $braintree_user_id = $this->get_braintree_user_id();
            }

            $delivery = $this->get_delivery();
            $total = $woocommerce->cart->cart_contents_total;
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
        $response = WC()->session->last_complete;
        $response['shipping'] = $this->get_shipping_details();
        $statusCode = 200;
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
                $response['errors'][] = sprintf('This account already exists. <a href="%s">Please sign in here</a>', '/checkout/#/login');
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
            $braintree_user_id = isset($data['braintree_customer_id']) ? $data['braintree_customer_id']: false;
        } else {
            $braintree_user_id = get_user_meta( $current_user->ID, 'braintree_customer_id', true );
        }
        if (!$braintree_user_id) {
            $billing = $this->get_billing_details();
            $result = Braintree_Customer::create([
                'firstName'             => $billing['first_name'],
                'lastName'              => $billing['last_name'],
                'company'               => $billing['company'],
                'phone'                 => $billing['phone'],
                'email'                 => $billing['email'],
            ]);
            if ($result->success) {
                $braintree_user_id = $result->customer->id;
                if ($guest = $this->guest_data()) {
                    $this->set_guest_data('braintree_customer_id', $braintree_user_id);
                } else {
                    update_user_meta( $current_user->ID, "braintree_customer_id", $braintree_user_id );
                }
            }
        }
        return $braintree_user_id;
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
    function set_wc_customer_data()
    {
        global $woocommerce;
        $billing = $this->get_billing_details();
        $shipping = $this->get_shipping_details();

        WC()->customer->set_country('US');
        WC()->customer->set_state( $billing['state'] );
        WC()->customer->set_postcode( $billing['postcode'] );
        WC()->customer->set_city( $billing['city'] );
        WC()->customer->set_address( $billing['address_1'] );
        WC()->customer->set_shipping_country( $shipping['country'] );
        WC()->customer->set_shipping_state( $shipping['state'] );
        WC()->customer->set_shipping_postcode( $shipping['postcode'] );
        WC()->customer->set_shipping_city( $shipping['city'] );
        WC()->customer->set_shipping_address( $shipping['address_1'] );
        WC()->cart->calculate_totals();
    }

}
new WP_Checkout_handler();
