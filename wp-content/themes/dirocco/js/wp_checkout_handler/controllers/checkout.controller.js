checkoutApp.controller('CheckoutBillingCtrl',['$scope','$http', '$location', '$state', 'checkoutBillingData', function($scope, $http, $location, $state, checkoutBillingData) {
    $scope.checkoutData = checkoutBillingData.data;

    if (!$scope.checkoutData.is_logged_in) {
        $state.go('auth');
    }

}]);

checkoutApp.controller('CheckoutLoginCtrl',['$scope','$http', '$location', '$state', function($scope, $http, $location, $state) {
	
}]);

checkoutApp.controller('CheckoutSignupCtrl',['$scope','$http', '$location', '$state', function($scope, $http, $location, $state) {
	
}]);