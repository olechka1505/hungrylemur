<div class="col-xs-12">
    <form class="col-md-4 checkout-form checkout-billing" ng-class="{'col-md-offset-1': !billingData.asShippingAddress, 'col-md-offset-4': billingData.asShippingAddress}" ng-submit="billing()">
        <h3 class="checkout-form-title text-center">BILLING ADDRESS</h3>
        <div class="form-group">
            <input ng-model="billingData.first_name" class="form-control" type="text" placeholder="First Name"/>
        </div>
        <div class="form-group">
            <input ng-model="billingData.last_name" class="form-control" type="text" placeholder="Last Name"/>
        </div>
        <div class="form-group">
            <input ng-model="billingData.company" class="form-control" type="text" placeholder="Company"/>
        </div>
        <div class="form-group">
            <input ng-model="billingData.address_1" class="form-control" type="text" placeholder="Street Address"/>
        </div>
        <div class="form-group">
            <input ng-model="billingData.suite" class="form-control" type="text" placeholder="Apt/Suite"/>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-xs-12 no-padding">
                <input ng-model="billingData.postcode" class="form-control" type="text" placeholder="Zip Code"/>
            </div>
            <div class="col-md-6 col-xs-12">
                Enter for City & State
            </div>
        </div>

        <div class="form-group">
            <label>
                <input ng-init="billingData.asShippingAddress = true"  ng-model="billingData.asShippingAddress" type="checkbox" />
                ALSO USE THIS AS MY SHIPPING ADDRESS
            </label>
        </div>

        <div class="form-group">
            <input ng-model="billingData.phone" class="form-control" type="text" placeholder="Phone Number"/>
        </div>

        <div class="form-group clearfix">
            <input class="btn btn-large btn-checkout" type="submit" value="CONTINUE"/>
        </div>
    </form>

    <form ng-if="!billingData.asShippingAddress" class="col-md-4 col-md-offset-1 col-xs-12 checkout-form checkout-shipping">
        <h3 class="checkout-form-title text-center">SHIPPING ADDRESS</h3>
        <div class="form-group">
            <input ng-model="shippingData.first_name" class="form-control" type="text" placeholder="First Name"/>
        </div>
        <div class="form-group">
            <input ng-model="shippingData.last_name" class="form-control" type="text" placeholder="Last Name"/>
        </div>
        <div class="form-group">
            <input ng-model="shippingData.company" class="form-control" type="text" placeholder="Company"/>
        </div>
        <div class="form-group">
            <input ng-model="shippingData.address_1" class="form-control" type="text" placeholder="Street Address"/>
        </div>
        <div class="form-group">
            <input ng-model="shippingData.suite" class="form-control" type="text" placeholder="Apt/Suite"/>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-xs-12 no-padding">
                <input ng-model="shippingData.postcode" class="form-control" type="text" placeholder="Zip Code"/>
            </div>
            <div class="col-md-6 col-xs-12">
                Enter for City & State
            </div>
        </div>
        <div class="form-group">
            <input ng-model="shippingData.phone" class="form-control" type="text" placeholder="Phone Number"/>
        </div>
    </form>


</div>