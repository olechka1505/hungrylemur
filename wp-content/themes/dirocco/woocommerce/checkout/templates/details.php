<div class="col-xs-12" ng-if="!process">
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-billing-details">
        <h3 class="checkout-form-title text-left">BILLING ADDRESS</h3>
        <p>{{detailsData.billing.first_name}} {{detailsData.billing.last_name}}</p>
        <p>{{detailsData.billing.suite}}, {{detailsData.billing.company}}</p>
        <p>{{detailsData.billing.address_1}}, {{detailsData.billing.postcode}}</p>
    </div>
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-shipping-details">
        <h3 class="checkout-form-title text-left">SHIPPING ADDRESS</h3>
        <p>{{detailsData.shipping.first_name}} {{detailsData.shipping.last_name}}</p>
        <p>{{detailsData.shipping.suite}}, {{detailsData.shipping.company}}</p>
        <p>{{detailsData.shipping.address_1}}, {{detailsData.shipping.postcode}}</p>
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
    <div class="col-xs-12 text-center">
        <input class="btn btn-large btn-checkout" ng-click="detailsSave()" type="button" value="CONTINUE"/>
    </div>
</div>