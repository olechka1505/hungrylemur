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
        .state('confirm', {
            url: "/confirm",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/confirm.php",
            controller:'CheckoutConfirmCtrl',
            resolve: {
                checkoutConfirmData: ['CheckoutService', function(CheckoutService) {
                    return CheckoutService.request('confirm', {})
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
        .state('payment', {
            url: "/payment",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/payment.php",
            controller:'CheckoutPaymentCtrl',
        })
        .state('forgot', {
            url: "/forgot",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/forgot.php",
            controller:'CheckoutForgotCtrl',
        })
    $urlRouterProvider.otherwise("/billing");
}]);