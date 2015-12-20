checkoutApp.controller('CheckoutBillingCtrl',['$scope','$http', '$location', '$state', 'checkoutBillingData', function($scope, $http, $location, $state, checkoutBillingData) {
    $scope.checkoutData = checkoutBillingData.data;

    if (!$scope.checkoutData.is_logged_in) {
        $state.go('auth');
    }

}]);

checkoutApp.controller('CheckoutAuthCtrl',['$scope','$http', '$location', '$state', 'checkoutAuthData', function($scope, $http, $location, $state, checkoutAuthData) {
    $scope.checkoutData = checkoutAuthData.data;

}]);