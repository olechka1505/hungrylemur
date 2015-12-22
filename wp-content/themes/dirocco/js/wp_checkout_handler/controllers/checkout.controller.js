checkoutApp.controller('CheckoutBillingCtrl',['$scope','$http', '$location', '$state', 'checkoutBillingData', 'CheckoutService', function($scope, $http, $location, $state, checkoutBillingData, CheckoutService) {
    $scope.billingData = checkoutBillingData.data.billing;
    $scope.shippingData = checkoutBillingData.data.shipping;
    $scope.states = states;
    $scope.process = false;
    $scope.errors = {
        billing: [],
        shipping: [],
    };

    $scope.billing = function() {
        $scope.process = true;
        var promise = CheckoutService.request('billing', {billingData: $scope.billingData, shippingData: $scope.shippingData});
        promise.then(function(response){
            if (response.data.status) {
                $state.go('details');
            } else {
                $scope.errors = response.data.invalid;
            }
        })
    }

    $scope.is_invalid = function(field, type){
        for (var i in $scope.errors[type]) {
            if ($scope.errors[type][i] == field) {
                return true;
            }
        }
        return false;
    }
}]);
checkoutApp.controller('CheckoutDetailsCtrl',['$scope','$http', '$location', '$state', 'checkoutDetailsData', 'CheckoutService', function($scope, $http, $location, $state, checkoutDetailsData, CheckoutService) {
    $scope.detailsData = checkoutDetailsData.data;
    $scope.deliveryData = {};
    $scope.process = false;

    $scope.detailsSave = function() {
        $scope.process = true;
        var promise = CheckoutService.request('details', {deliveryData: $scope.deliveryData});
        promise.then(function(response){
            if (response.data.status) {
                $state.go('payment');
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

checkoutApp.controller('CheckoutPaymentCtrl',['$scope','$http', '$location', '$state', 'CheckoutService', function($scope, $http, $location, $state, CheckoutService) {
    $scope.paymentData = {};
    $scope.years = [2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2030];
    $scope.month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    $scope.process = false;

    $scope.payment = function() {
        $scope.process = true;
        var promise = CheckoutService.request('payment', {paymentData: $scope.paymentData});
        promise.then(function(response){
            if (response.data.status) {
                $state.go('confirm');
            }
        })
    }
}]);

checkoutApp.controller('CheckoutConfirmCtrl',['$scope','$http', '$location', '$state', 'checkoutConfirmData', 'CheckoutService', function($scope, $http, $location, $state, checkoutConfirmData, CheckoutService) {
    $scope.confirmData = checkoutConfirmData.data;

    console.log($scope.confirmData)

    $scope.confirm = function() {
        var promise = CheckoutService.request('confirm', {confirmData: $scope.confirmData});
        promise.then(function(response){
            if (response.data.status) {
                //$state.go('billing');
            }
        })
    }
}]);

checkoutApp.controller('CheckoutGuestCtrl',['$scope','$http', '$location', '$state', 'CheckoutService', function($scope, $http, $location, $state, CheckoutService) {
    $scope.guestData = {};

    $scope.guest = function() {
        var promise = CheckoutService.request('guest', {guestData: $scope.guestData});
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