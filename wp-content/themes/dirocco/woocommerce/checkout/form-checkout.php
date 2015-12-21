<div ng-app="checkoutApp">
	<div ng-show="loading">
		<span class="">Loading...</span>
	</div>
	<div ng-hide="loading" class="col-md-12">
		<div ng-if="hasError" class="col-xs-12 has-error error">
			<p ng-repeat="error in errors">{{error}}</p>
		</div>
		<div ui-view></div>
	</div>
</div>