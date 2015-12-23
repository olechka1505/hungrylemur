<div class="col-xs-12">
    <div class="col-md-4 col-xs-12 align-center">
        <h3 class="checkout-form-title text-center">PAYMENT DETAILS</h3>
    </div>

    <form id="checkout-payment" ng-submit="payment()">
        <div class="col-md-8 col-xs-12">
            <div class="col-xs-12">
                <label>Expiration date</label>
            </div>
            <div class="col-md-6 col-xs-12">
                <input data-braintree-name="number" ng-class="{'error-field': errors.number}" type="text" maxlength="16" ng-model="paymentData.number" class="form-control" placeholder="Credit Card">
            </div>
            <div class="col-md-2 col-xs-12">
                <select data-braintree-name="expiration_month" ng-class="{'error-field': errors.month}"  ng-model="paymentData.month" class="form-control">
                    <option value="">Month</option>
                    <option value="{{key + 1}}" ng-repeat="(key, value) in month">{{value}}</option>
                </select>
            </div>
            <div class="col-md-2 col-xs-12">
                <select data-braintree-name="expiration_year" ng-class="{'error-field': errors.year}" ng-model="paymentData.year" class="form-control">
                    <option value="">Year</option>
                    <option value="{{year}}" ng-repeat="year in years">{{year}}</option>
                </select>
            </div>
            <div class="col-md-2 col-xs-12">
                <input data-braintree-name="cvv" ng-class="{'error-field': errors.cvc}"  type="text" maxlength="4" ng-model="paymentData.cvc" class="form-control" placeholder="CVC">
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="col-xs-12">
                <label>Have a Promo Code?</label>
            </div>
            <div class="col-md-6 col-xs-12">
                <input type="text" ng-model="paymentData.promo" class="form-control" placeholder="Promo Code">
            </div>
            <div class="col-md-6 col-xs-12">
                <input type="button" class="btn btn-checkout" value="APPLY">
            </div>
        </div>

        <div class="separator"></div>
        <div class="separator"></div>

        <div class="col-xs-12 text-center">
            <input type="submit" class="btn btn-checkout" value="REVIEW & SUBMIT">
        </div>
    </form>
</div>