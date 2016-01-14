checkoutApp.factory('CheckoutService', ['$http', '$rootScope', '$state', function($http, $rootScope, $state){
    return {
        request: function(action, data, disable_loader) {
            disable_loader = disable_loader || false;
            if (!disable_loader)
                $rootScope.loading = true;
            $rootScope.hasError = false;
            $rootScope.statusCode = 200;
            data = data || {};
            data.action = ajaxPrefix + action;
            return $http({
                url: ajaxUrl,
                method: 'POST',
                data: data,
                transformRequest: function(obj){
                    return 'action=' + data.action + '&data=' + JSON.stringify(obj);
                },
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            }).then(function(response){
                $rootScope.statusCode = response.status;
                if (!disable_loader)
                    $rootScope.loading = false;
                return response;
            }, function(response){
                $rootScope.hasError = true;
                if (!disable_loader)
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