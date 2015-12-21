<?php

class WP_Checkout_handler
{
    public $ajaxUrl = false;
    public $ajaxPrefix = false;
    function __construct()
    {
        $this->ajaxUrl = admin_url('admin-ajax.php');
        $this->ajaxPrefix = 'wp_checkout_';

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
    }

    function details()
    {
        // if user is not logged in
        if (!is_user_logged_in()) {
            $this->response(array(
                'message' => 'Forbidden',
            ), 403);
        }
        global $current_user;
        // get billing details
        $response['billing'] = $this->get_billing_details();
        // get shipping details
        $response['shipping'] = $this->get_shipping_details();
        $this->response($response);
    }

    function billing()
    {
        // if user is not logged in
        if (!is_user_logged_in()) {
            $this->response(array(
                'message' => 'Forbidden',
            ), 403);    
        }

        global $current_user;
        $billing = $this->data('billingData');
        $shipping = $this->data('shippingData');

        if ($billing) {
            // update billing info
            update_user_meta( $current_user->ID, "billing_first_name", $billing['first_name'] );
            update_user_meta( $current_user->ID, "billing_last_name", $billing['last_name'] );
            update_user_meta( $current_user->ID, "billing_company", $billing['company'] );
            update_user_meta( $current_user->ID, "billing_address_1", $billing['address_1'] );
            update_user_meta( $current_user->ID, "billing_postcode", $billing['postcode'] );
            update_user_meta( $current_user->ID, "billing_phone", $billing['phone'] );
            update_user_meta( $current_user->ID, "billing_suite", $billing['suite'] );

            // update shipping info
            $shipping = $billing['asShippingAddress'] ? $billing: $shipping;
            update_user_meta( $current_user->ID, "shipping_first_name", $shipping['first_name'] );
            update_user_meta( $current_user->ID, "shipping_last_name", $shipping['last_name'] );
            update_user_meta( $current_user->ID, "shipping_company", $shipping['company'] );
            update_user_meta( $current_user->ID, "shipping_address_1", $shipping['address_1'] );
            update_user_meta( $current_user->ID, "shipping_postcode", $shipping['postcode'] );
            update_user_meta( $current_user->ID, "shipping_phone", $shipping['phone'] );
            update_user_meta( $current_user->ID, "shipping_suite", $shipping['suite'] );

            $response['status'] = true;
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
        $response['billing']['first_name'] = get_user_meta( $current_user->ID, 'billing_first_name', true );
        $response['billing']['last_name'] = get_user_meta( $current_user->ID, 'billing_last_name', true );
        $response['billing']['company'] = get_user_meta( $current_user->ID, 'billing_company', true );
        $response['billing']['address_1'] = get_user_meta( $current_user->ID, 'billing_address_1', true );
        $response['billing']['postcode'] = get_user_meta( $current_user->ID, 'billing_postcode', true );
        $response['billing']['phone'] = get_user_meta( $current_user->ID, 'billing_phone', true );
        $response['billing']['suite'] = get_user_meta( $current_user->ID, 'billing_suite', true );
        return $response['billing'];
    }

    function get_shipping_details()
    {
        global $current_user;
        $response['shipping']['first_name'] = get_user_meta( $current_user->ID, 'shipping_first_name', true );
        $response['shipping']['last_name'] = get_user_meta( $current_user->ID, 'shipping_last_name', true );
        $response['shipping']['company'] = get_user_meta( $current_user->ID, 'shipping_company', true );
        $response['shipping']['address_1'] = get_user_meta( $current_user->ID, 'shipping_address_1', true );
        $response['shipping']['postcode'] = get_user_meta( $current_user->ID, 'shipping_postcode', true );
        $response['shipping']['suite'] = get_user_meta( $current_user->ID, 'shipping_suite', true );
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
        
        //some variables to scripts
        wp_localize_script('angular.service.checkout', 'ajaxUrl', $this->ajaxUrl);
        wp_localize_script('angular.service.checkout', 'ajaxPrefix', $this->ajaxPrefix);
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

}
new WP_Checkout_handler();