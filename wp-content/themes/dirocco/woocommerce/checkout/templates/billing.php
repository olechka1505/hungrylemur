<div class="col-xs-12" ng-if="!process">
    <form class="col-md-4 checkout-form checkout-billing" ng-class="{'col-md-offset-1': !billingData.asShippingAddress, 'col-md-offset-4': billingData.asShippingAddress}" ng-submit="billing()">
        <h3 class="checkout-form-title text-center">BILLING ADDRESS</h3>
        <div class="form-group">
            <input ng-class="{error: is_invalid('first_name', 'billing')}" ng-model="billingData.first_name" class="form-control" type="text" placeholder="First Name"/>
        </div>
        <div class="form-group">
            <input ng-class="{error: is_invalid('last_name', 'billing')}" ng-model="billingData.last_name" class="form-control" type="text" placeholder="Last Name"/>
        </div>
        <div class="form-group">
            <input ng-class="{error: is_invalid('company', 'billing')}" ng-model="billingData.company" class="form-control" type="text" placeholder="Company"/>
        </div>
        <div class="form-group">
            <input ng-class="{error: is_invalid('address_1', 'billing')}" ng-model="billingData.address_1" class="form-control" type="text" placeholder="Street Address"/>
        </div>
        <div class="form-group">
            <input ng-class="{error: is_invalid('suite', 'billing')}" ng-model="billingData.suite" class="form-control" type="text" placeholder="Apt/Unit"/>
        </div>
        <div class="form-group">
            <input ng-class="{error: is_invalid('city', 'billing')}" ng-model="billingData.city" class="form-control" type="text" placeholder="City"/>
        </div>
        <div class="form-group">
            <select
                ng-class="{error: is_invalid('state', 'billing')}"
                ng-model="billingData.state" class="form-control">
                <option value="">State</option>
                <option value="{{key}}" ng-repeat="(key, value) in states">{{value}}</option>
            </select>
        </div>

        <div class="form-group clearfix">
            <div class="col-md-6 col-xs-12 no-padding">
                <input ng-class="{error: is_invalid('postcode', 'billing')}" ng-model="billingData.postcode" class="form-control" type="text" placeholder="Zip Code"/>
            </div>
        </div>

        <div class="form-group">
            <input ng-class="{error: is_invalid('phone', 'billing')}" ng-model="billingData.phone" class="form-control" type="text" placeholder="Phone Number"/>
        </div>

        <div class="form-group">
            <label>
                <input ng-model="billingData.asShippingAddress" type="checkbox" />
                ALSO USE THIS AS MY SHIPPING ADDRESS
            </label>
        </div>

        <div class="form-group clearfix text-right">
            <input class="btn btn-large btn-checkout" type="submit" value="CONTINUE"/>
        </div>
    </form>

    <form ng-if="!billingData.asShippingAddress" class="col-md-4 col-md-offset-1 col-xs-12 checkout-form checkout-shipping">
        <h3 class="checkout-form-title text-center">SHIPPING ADDRESS</h3>
        <div class="form-group">
            <input ng-class="{error: is_invalid('first_name', 'shipping')}" ng-model="shippingData.first_name" class="form-control" type="text" placeholder="First Name"/>
        </div>
        <div class="form-group">
            <input ng-class="{error: is_invalid('last_name', 'shipping')}" ng-model="shippingData.last_name" class="form-control" type="text" placeholder="Last Name"/>
        </div>
        <div class="form-group">
            <input ng-class="{error: is_invalid('company', 'shipping')}" ng-model="shippingData.company" class="form-control" type="text" placeholder="Company"/>
        </div>
        <div class="form-group">
            <input ng-class="{error: is_invalid('address_1', 'shipping')}" ng-model="shippingData.address_1" class="form-control" type="text" placeholder="Street Address"/>
        </div>
        <div class="form-group">
            <input ng-class="{error: is_invalid('suite', 'shipping')}" ng-model="shippingData.suite" class="form-control" type="text" placeholder="Apt/Unit"/>
        </div>
        <div class="form-group">
            <input ng-class="{error: is_invalid('city', 'shipping')}" ng-model="shippingData.city" class="form-control" type="text" placeholder="City"/>
        </div>
        <div class="form-group">
            <select
                ng-class="{error: is_invalid('state', 'shipping')}"
                ng-model="shippingData.state" class="form-control">
                <option value="">State</option>
                <option value="{{key}}" ng-repeat="(key, value) in states">{{value}}</option>
            </select>
        </div>
        <div class="form-group clearfix">
            <div class="col-md-6 col-xs-12 no-padding">
                <input ng-class="{error: is_invalid('postcode', 'shipping')}" ng-model="shippingData.postcode" class="form-control" type="text" placeholder="Zip Code"/>
            </div>
        </div>
        <div class="form-group">
            <input ng-class="{error: is_invalid('phone', 'shipping')}" ng-model="shippingData.phone" class="form-control" type="text" placeholder="Phone Number"/>
        </div>
    </form>
</div>