checkoutApp.controller('CheckoutBillingCtrl',['$scope','$http', '$location', '$state', '$rootScope', 'checkoutBillingData', 'CheckoutService', function($scope, $http, $location, $state, $rootScope, checkoutBillingData, CheckoutService) {
    $scope.billingData = checkoutBillingData.data.billing || {};
    $scope.shippingData = checkoutBillingData.data.shipping || {};
    $scope.states = states;
    $scope.process = false;
    $scope.billingData.asShippingAddress = typeof($rootScope.type) !== 'undefined' ?  $rootScope.type != 'shipping': true;
    
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
                $scope.process = false;
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
checkoutApp.controller('CheckoutDetailsCtrl',['$scope','$http', '$location', '$state', '$rootScope', 'checkoutDetailsData', 'CheckoutService', function($scope, $http, $location, $state, $rootScope, checkoutDetailsData, CheckoutService) {
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

    $scope.edit = function(type){
        $rootScope.type = type;
        $state.go('billing');
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
    $scope.errors = {
        number: false,
        month: false,
        year: false,
        cvc: false,
    };
    $scope.clientToken = clientToken;
    delete (clientToken);
    
    $scope.promo = function(){
        var promise = CheckoutService.request('promo', {promo: $scope.paymentData.promo});
        promise.then(function(response){
            if (response.data.status) {
                //$state.go('payment');
            }
        })
    },
    
    $scope.payment = function() {
        $scope.process = true;
        
        $scope.errors.number = typeof($scope.paymentData.number) == 'undefined' || !$scope.paymentData.number.length;
        $scope.errors.month = typeof($scope.paymentData.month) == 'undefined' || !$scope.paymentData.month.length;
        $scope.errors.year = typeof($scope.paymentData.year) == 'undefined' || !$scope.paymentData.year.length;
        $scope.errors.cvc = typeof($scope.paymentData.cvc) == 'undefined' || !$scope.paymentData.cvc.length;


        if (!$scope.errors.number && !$scope.errors.month && !$scope.errors.year && !$scope.errors.cvc) {
            var client = new braintree.api.Client({clientToken: $scope.clientToken});
            client.tokenizeCard({
              number: $scope.paymentData.number,
              expirationMonth: $scope.paymentData.month,
              expirationYear: $scope.paymentData.year,
              cvv: $scope.paymentData.cvc,
            }, function (err, nonce, card) {
                var promise = CheckoutService.request('payment', {nonce: nonce});
                promise.then(function(response){
                    if (response.status !== 500) {
                        $state.go('complete', {order_id: response.data.order_id});
                    }
                })
            });
        }
    }
    
}]);

checkoutApp.controller('CheckoutCompleteCtrl',['$scope','$http', '$location', '$state', 'checkoutCompleteData', 'CheckoutService', function($scope, $http, $location, $state, checkoutCompleteData, CheckoutService) {
    $scope.completeData = checkoutCompleteData.data;


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
