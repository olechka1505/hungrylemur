<div class="col-xs-12" ng-if="!process">
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-shipping-details">
        <div class="col-xs-12 no-padding">
            <h3 class="checkout-form-title text-left">SHIPPING ADDRESS</h3>
            <p>{{confirmData.shipping.first_name}} {{confirmData.shipping.last_name}}</p>
            <p ng-if="confirmData.shipping.company">{{confirmData.shipping.company}}</p>
            <p><span>{{confirmData.shipping.address_1}}</span><span ng-if="confirmData.shipping.suite">, {{confirmData.shipping.suite}}</span></p>
            <p>{{confirmData.shipping.city}}, {{confirmData.shipping.state}}, {{confirmData.shipping.postcode}}</p>
        </div>

        <div class="col-xs-12 checkout-title-separator clearfix no-padding">DELIVERY OPTIONS</div>

        <div class="col-xs-12 no-padding">
            <p ng-if="confirmData.delivery.standard">
                <label>
                    Standard Shipping (Free)
                </label><br/>
                <small>5 Business days.</small>
            </p>
            <p ng-if="confirmData.delivery.expedited">
                <label>
                    Expedited Shipping (+$40)
                </label><br/>
                <small>Orders placed before 1 p.m. ET will be delivered
                    by the end of the next business day.</small>
            </p>
        </div>

        <div class="col-xs-12 checkout-title-separator clearfix no-padding">CREDIT CARD</div>

        <div class="col-xs-12 no-padding">
            <p><strong>{{confirmData.card.type}}: {{confirmData.card.bin + '******' + confirmData.card.last4}}</strong></p>
        </div>
    </div>

    <div class="col-md-7 col-xs-12">
        <table class="checkout-confirm-table">
            <tr ng-repeat="product in confirmData.products">
                <td><img ng-src="{{product.image}}" alt=""></td>
                <td class="text-center">{{product.name}}</td>
                <td class="text-center">{{product.cat}}</td>
                <td class="text-center">{{product.qty}}</td>
                <td class="text-right">{{product.price | currency}}</td>
            </tr>
        </table>
        <div class="col-md-4 col-xs-12 text-right pull-right">
            <div ng-if="confirmData.subtotal" class="text-right"><strong ng-bind-html="'SUBTOTAL: ' + confirmData.subtotal"></strong></div>
            <div ng-if="confirmData.delivery.standard" class="text-right"><strong>SHIPPING: FREE</strong></div>
            <div ng-if="confirmData.delivery.expedited" class="text-right"><strong>SHIPPING: +$40</strong></div>
            <div class="text-right"><strong>TAX: {{confirmData.tax | currency}}</strong></div>
            <div ng-if="confirmData.total" class="text-right"><strong>TOTAL: {{confirmData.total | currency}}</strong></div>

            <div class="separator"></div>
            <a ui-sref="complete" class="btn btn-checkout">SUBMIT ORDER</a>
        </div>
    </div>

</div>