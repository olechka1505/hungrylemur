checkoutApp.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider){
    $stateProvider
        .state('billing', {
            url: "/billing",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/billing.php",
            controller:'CheckoutBillingCtrl',
            resolve: {
                checkoutBillingData: ['CheckoutService', function(CheckoutService) {
                    return CheckoutService.request('billing', {})
                }],
            },
        })
        .state('details', {
            url: "/details",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/details.php",
            controller:'CheckoutDetailsCtrl',
            resolve: {
                checkoutDetailsData: ['CheckoutService', function(CheckoutService) {
                    return CheckoutService.request('details', {})
                }],
            },
        })
        .state('confirmOrder', {
            url: "/confirmOrder",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/confirmOrder.php",
            controller:'CheckoutConfirmOrderCtrl',
            resolve: {
                checkoutConfirmOrderData: ['CheckoutService', function(CheckoutService) {
                    return CheckoutService.request('confirmOrder', {})
                }],
            },
        })
        .state('complete', {
            url: "/complete/:order_id",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/complete.php",
            controller:'CheckoutCompleteCtrl',
            resolve: {
                checkoutCompleteData: ['CheckoutService', '$stateParams', function(CheckoutService, $stateParams) {
                    return CheckoutService.request('complete', {order_id: $stateParams.order_id})
                }],
            },
        })
        .state('login', {
            url: "/login",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/login.php",
            controller:'CheckoutLoginCtrl',
        })
        .state('signup', {
            url: "/signup",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/signup.php",
            controller:'CheckoutSignupCtrl',
        })
        .state('guest', {
            url: "/guest",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/guest.php",
            controller:'CheckoutGuestCtrl',
        })
        .state('forgot', {
            url: "/forgot",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/forgot.php",
            controller:'CheckoutForgotCtrl',
        })
    $urlRouterProvider.otherwise("/billing");
}]);