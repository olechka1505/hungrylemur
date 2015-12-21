<div class="col-xs-12">
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-billing-details">
        <h3 class="checkout-form-title text-left">BILLING ADDRESS</h3>
        <p>{{details.billing.first_name}} {{details.billing.last_name}}</p>
        <p>{{details.billing.suite}}, {{details.billing.company}}</p>
        <p>{{details.billing.address_1}}, {{details.billing.postcode}}</p>
    </div>
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-shipping-details">
        <h3 class="checkout-form-title text-left">SHIPPING ADDRESS</h3>
        <p>{{details.shipping.first_name}} {{details.shipping.last_name}}</p>
        <p>{{details.shipping.suite}}, {{details.shipping.company}}</p>
        <p>{{details.shipping.address_1}}, {{details.shipping.postcode}}</p>
    </div>
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-delivery-details">
        <h3 class="checkout-form-title text-left">DELIVERY OPTIONS</h3>
        <p>
            <label>
                <input ng-model="delivery.standard" type="checkbox" />
                Standard Shipping (Free)
            </label><br/>
            <small>5 Business days.</small>
        </p>
        <p>
            <label>
                <input ng-model="delivery.expedited" type="checkbox" />
                Expedited Shipping (+$40)
            </label><br/>
            <small>Orders placed before 1 p.m. ET will be delivered
            by the end of the next business day.</small>
        </p>
    </div>
    <div class="col-xs-12 text-center">
        <input class="btn btn-large btn-checkout" type="button" value="CONTINUE"/>
    </div>
</div>