checkoutApp.factory('CheckoutService', ['$http', '$rootScope', '$state', function($http, $rootScope, $state){
    return {
        request: function(action, data) {
            $rootScope.loading = true;
            data.action = ajaxPrefix + action;
            data = data || {};
            return $http({
                url: ajaxUrl,
                method: 'POST',
                data: data,
            }).then(function(response){
                $rootScope.statusCode = response.status;
                $rootScope.loading = false;
                return response;
            }, function(response){
                $rootScope.hasError = true;
                $rootScope.loading = false;
                $rootScope.statusCode = response.status;
                switch (response.status) {
                    case 403:
                        $state.go('login');
                        break;
                    case 500:
                    default:
                        $rootScope.errors = response.data.errors;
                        break;
                }
                return response;
            });
        }
    };
}])