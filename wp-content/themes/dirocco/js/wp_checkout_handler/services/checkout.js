checkoutApp.factory('CheckoutService', ['$http', '$rootScope', function($http, $rootScope){
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
                $rootScope.errors = response.data.errors;
                $rootScope.loading = false;
                return response;
            });
        }
    };
}])