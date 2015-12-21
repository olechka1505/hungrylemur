<div ng-app="checkoutApp">
	<div ng-show="loading">
		<div class="col-xs-12 checkout-loading text-center">
			<h3>Loading...</h3>
		</div>
	</div>
	<div ng-hide="loading" class="col-md-12">
		<div ng-if="hasError" class="col-md-3 col-xs-12 has-error error align-center">
			<p ng-repeat="error in errors" ng-bind-html="error"></p>
		</div>
		<div ui-view></div>
	</div>
</div>