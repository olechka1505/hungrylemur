checkoutApp.controller('CheckoutBillingCtrl',['$scope','$http', '$location', '$state', 'checkoutBillingData', function($scope, $http, $location, $state, checkoutBillingData) {
    $scope.checkoutData = checkoutBillingData.data;

}]);

checkoutApp.controller('CheckoutLoginCtrl',['$scope','$http', '$location', '$state', 'CheckoutService', function($scope, $http, $location, $state, CheckoutService) {
    $scope.loginData = {};
    
    $scope.login = function() {
        var response = CheckoutService.request('login', {loginData: $scope.loginData});
        if (response && response.status) {
            $state.go('billing');
        }
        
    }
}]);

checkoutApp.controller('CheckoutSignupCtrl',['$scope','$http', '$location', '$state', function($scope, $http, $location, $state) {
    $scope.signupData = {};
    
    $scope.signup = function() {
        var response = CheckoutService.request('signup', {signupData: $scope.signupData});
        if (response && response.status) {
            $state.go('billing');
        }
        
    }
}]);

checkoutApp.controller('CheckoutForgotCtrl',['$scope','$http', '$location', '$state', function($scope, $http, $location, $state) {
	
}]);