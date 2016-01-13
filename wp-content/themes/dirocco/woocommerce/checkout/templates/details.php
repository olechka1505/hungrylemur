<div class="col-xs-12" ng-if="!process">
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-billing-details">
        <div class="col-xs-11 no-padding">
            <h3 class="checkout-form-title text-left">BILLING ADDRESS</h3>
            <p>{{detailsData.billing.first_name}} {{detailsData.billing.last_name}}</p>
            <p ng-if="detailsData.billing.company">{{detailsData.billing.company}}</p>
            <p><span>{{detailsData.billing.address_1}}</span><span ng-if="detailsData.billing.suite">, {{detailsData.billing.suite}}</span></p>
            <p>{{detailsData.billing.city}}, {{detailsData.billing.state}}, {{detailsData.billing.postcode}}</p>
        </div>
        <div class="col-xs-1 no-padding">
            <a ng-click="edit('billing')" class="btn-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
        </div>
    </div>
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-shipping-details">
        <div class="col-xs-11 no-padding">
            <h3 class="checkout-form-title text-left">SHIPPING ADDRESS</h3>
            <p>{{detailsData.shipping.first_name}} {{detailsData.shipping.last_name}}</p>
            <p ng-if="detailsData.shipping.company">{{detailsData.shipping.company}}</p>
            <p><span>{{detailsData.shipping.address_1}}</span><span ng-if="detailsData.shipping.suite">, {{detailsData.shipping.suite}}</span></p>
            <p>{{detailsData.shipping.city}}, {{detailsData.shipping.state}}, {{detailsData.shipping.postcode}}</p>
        </div>
        <div class="col-xs-1 no-padding">
            <a ng-click="edit('shipping')" class="btn-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
        </div>
    </div>
    <div ng-if="!shipping_loading" class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-delivery-details">
        <h3 class="checkout-form-title text-left">DELIVERY OPTIONS</h3>
        <div class="col-xs-12" ng-repeat="rate in detailsData.rates">
            <input type="radio" ng-model="detailsData.chosen_shipping_methods" ng-value="rate.id"/> {{rate.label}} - ({{rate.cost | currency}})
        </div>
    </div>
    <div ng-if="shipping_loading">Loading...</div>
</div>
<div class="col-xs-12" ng-if="!process">
    <div class="col-md-9 col-md-offset-1 col-xs-12 checkout-payment-details">
        <div class="col-md-6 col-xs-12 no-padding">
            <h3 class="checkout-form-title no-padding-left">PAYMENT DETAILS</h3>
        </div>

        <div class="col-md-8 col-xs-12 no-padding">
            <!--<div class="form-group col-xs-12 no-padding-left">
                <label>Expiration date</label>
            </div>
			-->
            <div class="form-group col-md-6 col-xs-12 no-padding-left">
                <input data-braintree-name="number" ng-class="{'error-field': errors.number}" type="text" maxlength="16" ng-model="paymentData.number" class="form-control" placeholder="Credit Card">
            </div>
            <div class="form-group col-md-2 col-xs-12 no-padding-left" style="width: 85px;">
                <select data-braintree-name="expiration_month" ng-class="{'error-field': errors.month}"  ng-model="paymentData.month" class="form-control">
                    <option value="">Month</option>
                    <option value="{{key + 1}}" ng-repeat="(key, value) in month">{{value}}</option>
                </select>
            </div>
            <div class="form-group col-md-2 col-xs-12 no-padding-left" style="width: 75px;">
                <select data-braintree-name="expiration_year" ng-class="{'error-field': errors.year}" ng-model="paymentData.year" class="form-control">
                    <option value="">Year</option>
                    <option value="{{year}}" ng-repeat="year in years">{{year}}</option>
                </select>
            </div>
            <div class="form-group col-md-2 col-xs-12 no-padding-left" style="width: 75px;">
                <input data-braintree-name="cvv" ng-class="{'error-field': errors.cvc}"  type="text" maxlength="4" ng-model="paymentData.cvc" class="form-control" placeholder="CVC">
            </div>
        </div>

        <!--<div class="col-md-4 col-xs-12 no-padding">
            <div class="form-group col-md-6 col-xs-12 no-padding-left">
                <input type="text" ng-model="paymentData.promo" class="form-control" placeholder="Promo Code">
            </div>
            <div class="form-group col-md-6 col-xs-12 no-padding-left">
                <input ng-if="!isPromo" type="button" ng-click="promo()" class="btn btn-checkout" value="APPLY">
                <i ng-if="isPromo" class="fa fa-check coupons-added"></i>
            </div>
        </div>-->

        <div class="separator"></div>
        <div class="separator"></div>

        <div class="col-xs-12 text-right">
            <a ui-sref="billing" class="btn btn-checkout">GO BACK</a>
            <input type="button" ng-click="payment()" class="btn btn-checkout" value="REVIEW ORDER">
        </div>
    </div>
</div>
