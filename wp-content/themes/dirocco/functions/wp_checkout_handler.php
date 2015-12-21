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
        add_action($this->ajax_full_action('login'), array($this, 'login'));
        add_action($this->ajax_full_action_nopriv('login'), array($this, 'login'));
        add_action($this->ajax_full_action('signup'), array($this, 'signup'));
        add_action($this->ajax_full_action_nopriv('signup'), array($this, 'signup'));
    }

    function billing()
    {
        // if user is not logged in
        if (!is_user_logged_in()) {
            $this->response(array(
                'message' => 'Forbidden',
            ), 403);    
        }
        
    }

    function login()
    {
        
    }
    
    function signup()
    {
        
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

    public function get_data()
    {
        if ($postdata = file_get_contents("php://input")) {
            return json_decode($postdata, TRUE);
        } else {
            return false;
        }
    }

}
new WP_Checkout_handler();