checkoutApp.controller('CheckoutBillingCtrl',['$scope','$http', '$location', '$state', '$rootScope', 'checkoutBillingData', 'CheckoutService', function($scope, $http, $location, $state, $rootScope, checkoutBillingData, CheckoutService) {
    $scope.billingData = checkoutBillingData.data.billing || {};
    $scope.shippingData = checkoutBillingData.data.shipping || {};
    $scope.states = states;
    $scope.process = false;
    $scope.billingData.asShippingAddress = typeof($rootScope.type) !== 'undefined' ?  $rootScope.type != 'shipping': true;

    $rootScope.breadcrumbs = [
        {type: 'link', title: 'HOME', url: home_url},
        {type: 'separator'},
        {type: 'link', title: 'CHECKOUT', url: checkout_url},
        {type: 'separator'},
        {type: 'span', title: 'BILLING'},
    ];
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
    $scope.paymentData = {};
    $scope.years = [2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2030];
    $scope.month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    $scope.errors = {
        number: false,
        month: false,
        year: false,
        cvc: false,
    };
    $scope.clientToken = clientToken;
    delete (clientToken);

    $rootScope.breadcrumbs = [
        {type: 'link', title: 'HOME', url: home_url},
        {type: 'separator'},
        {type: 'link', title: 'CHECKOUT', url: checkout_url},
        {type: 'separator'},
        {type: 'span', title: 'PAYMENT DETAILS'},
    ];

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
    
    $scope.promo = function(){
        var promise = CheckoutService.request('promo', {promo: $scope.paymentData.promo});
        promise.then(function(response){
            if (response.data.status) {
                //$state.go('payment');
            }
        })
    },
    
    $scope.payment = function() {
        $scope.errors.number = typeof($scope.paymentData.number) == 'undefined' || !$scope.paymentData.number.length;
        $scope.errors.month = typeof($scope.paymentData.month) == 'undefined' || !$scope.paymentData.month.length;
        $scope.errors.year = typeof($scope.paymentData.year) == 'undefined' || !$scope.paymentData.year.length;
        $scope.errors.cvc = typeof($scope.paymentData.cvc) == 'undefined' || !$scope.paymentData.cvc.length;

        if (!$scope.errors.number && !$scope.errors.month && !$scope.errors.year && !$scope.errors.cvc) {
            $scope.process = true;
            var client = new braintree.api.Client({clientToken: $scope.clientToken});
            client.tokenizeCard({
              number: $scope.paymentData.number,
              expirationMonth: $scope.paymentData.month,
              expirationYear: $scope.paymentData.year,
              cvv: $scope.paymentData.cvc,
            }, function (err, nonce, card) {
                var promise = CheckoutService.request('payment', {nonce: nonce, deliveryData: $scope.deliveryData});
                promise.then(function(response){
                    if (response.status !== 500) {
                        $state.go('confirmOrder');
                    } else {
                        $scope.process = false;
                    }
                })
            });
        }
    }

}]);

checkoutApp.controller('CheckoutLoginCtrl',['$scope','$http', '$location', '$state', '$rootScope', 'CheckoutService', function($scope, $http, $location, $state, $rootScope, CheckoutService) {
    $scope.loginData = {};
    $rootScope.breadcrumbs = [
        {type: 'link', title: 'HOME', url: home_url},
        {type: 'separator'},
        {type: 'span', title: 'CHECKOUT'},
    ];
    $scope.login = function() {
        var promise = CheckoutService.request('login', {loginData: $scope.loginData});
        promise.then(function(response){
            if (response.data.status) {
                $state.go('billing');
            }
        })
    }
}]);

checkoutApp.controller('CheckoutCompleteCtrl',['$scope','$http', '$location', '$state', '$rootScope', 'checkoutCompleteData', 'CheckoutService', function($scope, $http, $location, $state, $rootScope, checkoutCompleteData, CheckoutService) {
    $scope.completeData = checkoutCompleteData.data;

    console.log($scope.completeData);
    $rootScope.breadcrumbs = [
        {type: 'link', title: 'HOME', url: home_url},
        {type: 'separator'},
        {type: 'link', title: 'CHECKOUT', url: checkout_url},
        {type: 'separator'},
        {type: 'span', title: 'VIEW ORDER'},
    ];
}]);

checkoutApp.controller('CheckoutGuestCtrl',['$scope','$http', '$location', '$state', '$rootScope', 'CheckoutService', function($scope, $http, $location, $state, $rootScope, CheckoutService) {
    $scope.guestData = {};
    $rootScope.breadcrumbs = [
        {type: 'link', title: 'HOME', url: home_url},
        {type: 'separator'},
        {type: 'link', title: 'CHECKOUT', url: checkout_url},
        {type: 'separator'},
        {type: 'span', title: 'GUEST'},
    ];
    $scope.guest = function() {
        var promise = CheckoutService.request('guest', {guestData: $scope.guestData});
        promise.then(function(response){
            if (response.data.status) {
                $state.go('billing');
            }
        })
    }
}]);

checkoutApp.controller('CheckoutSignupCtrl',['$scope','$http', '$location', '$state', '$rootScope', 'CheckoutService', function($scope, $http, $location, $state, $rootScope, CheckoutService) {
    $scope.signupData = {};
    $rootScope.breadcrumbs = [
        {type: 'link', title: 'HOME', url: home_url},
        {type: 'separator'},
        {type: 'span', title: 'SIGN UP'},
    ];
    $scope.signup = function() {
        var promise = CheckoutService.request('signup', {signupData: $scope.signupData});
        promise.then(function(response){
            if (response.data.status) {
                $state.go('billing');
            }
        })
    }
}]);

checkoutApp.controller('CheckoutConfirmOrderCtrl',['$scope','$http', '$location', '$state', '$rootScope', 'CheckoutService', 'checkoutConfirmOrderData', function($scope, $http, $location, $state, $rootScope, CheckoutService, checkoutConfirmOrderData) {
	$scope.confirmData = checkoutConfirmOrderData.data;
    $scope.createAccount = {
        action: 'createAccount',
    };

    $rootScope.breadcrumbs = [
        {type: 'link', title: 'HOME', url: home_url},
        {type: 'separator'},
        {type: 'link', title: 'CHECKOUT', url: checkout_url},
        {type: 'separator'},
        {type: 'span', title: 'CONFIRM ORDER'},
    ];

    $scope.confirmOrder = function(){
        var promise = CheckoutService.request('confirmOrder', {createAccount: $scope.createAccount});
        promise.then(function(response){
            if (response.data.status) {
                $state.go('complete');
            }
        })
    };

}]);

checkoutApp.controller('CheckoutForgotCtrl',['$scope','$http', '$location', '$state', function($scope, $http, $location, $state) {

}]);
