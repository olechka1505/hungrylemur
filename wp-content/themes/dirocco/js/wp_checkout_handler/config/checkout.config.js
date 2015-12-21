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
        .state('forgot', {
            url: "/forgot",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/forgot.php",
            controller:'CheckoutForgotCtrl',
        })
    $urlRouterProvider.otherwise("/billing");
}]);