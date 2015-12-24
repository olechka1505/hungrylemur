<div class="col-xs-12" ng-if="!process">
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-billing-details">
        <div class="col-xs-11 no-padding">
            <h3 class="checkout-form-title text-left">BILLING ADDRESS</h3>
            <p>{{detailsData.billing.first_name}} {{detailsData.billing.last_name}}</p>
            <p>{{detailsData.billing.suite}}, {{detailsData.billing.company}}</p>
            <p>{{detailsData.billing.address_1}}, {{detailsData.billing.postcode}}</p>
        </div>
        <div class="col-xs-1 no-padding">
            <a ng-click="edit('billing')" class="btn-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
        </div>
    </div>
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-shipping-details">
        <div class="col-xs-11 no-padding">
            <h3 class="checkout-form-title text-left">SHIPPING ADDRESS</h3>
            <p>{{detailsData.shipping.first_name}} {{detailsData.shipping.last_name}}</p>
            <p>{{detailsData.shipping.suite}}, {{detailsData.shipping.company}}</p>
            <p>{{detailsData.shipping.address_1}}, {{detailsData.shipping.postcode}}</p>
        </div>
        <div class="col-xs-1 no-padding">
            <a ng-click="edit('shipping')" class="btn-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
        </div>
    </div>
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-delivery-details">
        <h3 class="checkout-form-title text-left">DELIVERY OPTIONS</h3>
        <p>
            <label>
                <input ng-model="deliveryData.standard" type="checkbox" />
                Standard Shipping (Free)
            </label><br/>
            <small>5 Business days.</small>
        </p>
        <p>
            <label>
                <input ng-model="deliveryData.expedited" type="checkbox" />
                Expedited Shipping (+$40)
            </label><br/>
            <small>Orders placed before 1 p.m. ET will be delivered
            by the end of the next business day.</small>
        </p>
    </div>
</div>
<div class="col-xs-12" ng-if="!process">
    <div class="col-md-9 col-md-offset-1 col-xs-12">
        <div class="col-md-6 col-xs-12 align-center">
            <h3 class="checkout-form-title text-center">PAYMENT DETAILS</h3>
        </div>

        <div class="col-md-8 col-xs-12 no-padding">
            <div class="form-group col-xs-12 no-padding-left">
                <label>Expiration date</label>
            </div>
            <div class="form-group col-md-6 col-xs-12 no-padding-left">
                <input data-braintree-name="number" ng-class="{'error-field': errors.number}" type="text" maxlength="16" ng-model="paymentData.number" class="form-control" placeholder="Credit Card">
            </div>
            <div class="form-group col-md-2 col-xs-12 no-padding-left">
                <select data-braintree-name="expiration_month" ng-class="{'error-field': errors.month}"  ng-model="paymentData.month" class="form-control">
                    <option value="">Month</option>
                    <option value="{{key + 1}}" ng-repeat="(key, value) in month">{{value}}</option>
                </select>
            </div>
            <div class="form-group col-md-2 col-xs-12 no-padding-left">
                <select data-braintree-name="expiration_year" ng-class="{'error-field': errors.year}" ng-model="paymentData.year" class="form-control">
                    <option value="">Year</option>
                    <option value="{{year}}" ng-repeat="year in years">{{year}}</option>
                </select>
            </div>
            <div class="form-group col-md-2 col-xs-12 no-padding-left">
                <input data-braintree-name="cvv" ng-class="{'error-field': errors.cvc}"  type="text" maxlength="4" ng-model="paymentData.cvc" class="form-control" placeholder="CVC">
            </div>
        </div>
        <div class="col-md-4 col-xs-12 no-padding">
            <div class="form-group col-xs-12 no-padding-left">
                <label>Have a Promo Code?</label>
            </div>
            <div class="form-group col-md-6 col-xs-12 no-padding-left">
                <input type="text" ng-model="paymentData.promo" class="form-control" placeholder="Promo Code">
            </div>
            <div class="form-group col-md-6 col-xs-12 no-padding-left">
                <input type="button" ng-click="promo()" class="btn btn-checkout" value="APPLY">
            </div>
        </div>

        <div class="separator"></div>
        <div class="separator"></div>

        <div class="col-xs-12 text-center">
            <a ui-sref="billing" class="btn btn-checkout">GO BACK</a>
            <input type="button" ng-click="payment()" class="btn btn-checkout" value="REVIEW ORDER">
        </div>
    </div>
</div>
