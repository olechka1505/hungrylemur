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
        .state('auth', {
            url: "/auth",
            templateUrl: "/wp-content/themes/dirocco/woocommerce/checkout/templates/auth.php",
            controller:'CheckoutAuthCtrl',
            resolve: {
                checkoutAuthData: ['CheckoutService', function(CheckoutService) {
                    return CheckoutService.request('auth', {})
                }],
            },
        })
    $urlRouterProvider.otherwise("/billing");
}]);