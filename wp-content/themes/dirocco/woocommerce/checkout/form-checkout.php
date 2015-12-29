<div class="checkout" ng-app="checkoutApp">
    <div ng-cloak ng-hide="loading" class="breadcrumbs">
        <div class="breadcrumbs-wrap">
            <ul>
                <li ng-repeat="breadcrumb in breadcrumbs" ng-class="{separator: breadcrumb.type == 'separator'}">
                    <a ng-if="breadcrumb.type == 'link'" href="{{breadcrumb.url}}">{{breadcrumb.title}}</a>
                    <span ng-if="breadcrumb.type == 'span'">{{breadcrumb.title}}</span>
                    <span ng-if="breadcrumb.type == 'separator'"> / </span>
                </li>
            </ul>
        </div>
    </div>
    <div ng-show="loading">
            <div class="col-xs-12 checkout-loading text-center">
                    <h3>Loading...</h3>
            </div>
    </div>
    <div ng-hide="loading" class="col-md-12">
            <div ng-if="hasError" class="col-xs-12 has-error error text-center">
                    <p ng-repeat="error in errors" ng-bind-html="error"></p>
            </div>
            <div ui-view></div>
    </div>
</div>