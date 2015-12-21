checkoutApp.controller('CheckoutBillingCtrl',['$scope','$http', '$location', '$state', 'checkoutBillingData', 'CheckoutService', function($scope, $http, $location, $state, checkoutBillingData, CheckoutService) {
    $scope.billingData = checkoutBillingData.data.billing;
    $scope.shippingData = checkoutBillingData.data.shipping;

    $scope.billing = function() {
        var promise = CheckoutService.request('billing', {billingData: $scope.billingData, shippingData: $scope.shippingData});
        promise.then(function(response){
            if (response.data.status) {
                $state.go('billing');
            }
        })
    }
}]);

checkoutApp.controller('CheckoutLoginCtrl',['$scope','$http', '$location', '$state', 'CheckoutService', function($scope, $http, $location, $state, CheckoutService) {
    $scope.loginData = {};
    
    $scope.login = function() {
        var promise = CheckoutService.request('login', {loginData: $scope.loginData});
        promise.then(function(response){
            if (response.data.status) {
                $state.go('billing');
            }
        })
    }
}]);

checkoutApp.controller('CheckoutSignupCtrl',['$scope','$http', '$location', '$state', 'CheckoutService', function($scope, $http, $location, $state, CheckoutService) {
    $scope.signupData = {};
    
    $scope.signup = function() {
        var promise = CheckoutService.request('signup', {signupData: $scope.signupData});
        promise.then(function(response){
            if (response.data.status) {
                $state.go('billing');
            }
        })
    }
}]);

checkoutApp.controller('CheckoutForgotCtrl',['$scope','$http', '$location', '$state', function($scope, $http, $location, $state) {
	
}]);