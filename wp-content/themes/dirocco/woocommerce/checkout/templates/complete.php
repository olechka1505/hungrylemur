<div class="col-xs-12">
	<div class="col-md-4 col-md-offset-1 col-xs-12">
		<p><strong>ORDER NUMBER: {{completeData.order_id}}</strong></p>
    </div>
</div>	
<div class="col-xs-12">
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-shipping-details">
        <div class="col-xs-12 no-padding">
            <h3 class="checkout-form-title text-left">SHIPPING ADDRESS</h3>
            <p>{{completeData.shipping.first_name}} {{completeData.shipping.last_name}}</p>
            <p ng-if="completeData.shipping.company">{{completeData.shipping.company}}</p>
            <p><span>{{completeData.shipping.address_1}}</span><span ng-if="completeData.shipping.suite">, {{completeData.shipping.suite}}</span></p>
            <p>{{completeData.shipping.city}}, {{completeData.shipping.state}}, {{completeData.shipping.postcode}}</p>
        </div>

        <div class="col-xs-12 checkout-title-separator clearfix no-padding">DELIVERY OPTIONS</div>

        <div class="col-xs-12 no-padding">
            <p ng-if="completeData.delivery.standard">
                <label>
                    Standard Shipping (Free)
                </label><br/>
                <small>5 Business days.</small>
            </p>
            <p ng-if="completeData.delivery.expedited">
                <label>
                    Expedited Shipping (+$40)
                </label><br/>
                <small>Orders placed before 1 p.m. ET will be delivered
                    by the end of the next business day.</small>
            </p>
        </div>

        <div class="col-xs-12 checkout-title-separator clearfix no-padding">CREDIT CARD</div>

        <div class="col-xs-12 no-padding">
            <p><strong>{{completeData.card.type}}: {{'****' + completeData.card.last4}}</strong></p>
        </div>
    </div>
	
    <div class="col-md-7 col-xs-12 checkout-product-summary">
        <table class="checkout-confirm-table">
            <tr ng-repeat="product in completeData.products">
                <td><img ng-src="{{product.image}}" alt=""></td>
                <td class="text-center">{{product.name}}</td>
                <td class="text-center">{{product.cat}}</td>
                <td class="text-center">{{product.qty}}</td>
                <td class="text-right">{{product.price | currency}}</td>
            </tr>
        </table>
        <div class="col-md-4 col-xs-12 text-right pull-right">
            <div ng-if="completeData.subtotal" class="text-right"><strong ng-bind-html="'SUBTOTAL: ' + completeData.subtotal"></strong></div>
            <div ng-if="completeData.delivery.standard" class="text-right"><strong>SHIPPING: FREE</strong></div>
            <div ng-if="completeData.delivery.expedited" class="text-right"><strong>SHIPPING: +$40</strong></div>
            <div class="text-right"><strong>TAX: {{completeData.tax | currency}}</strong></div>
            <div ng-if="completeData.total" class="text-right"><strong>TOTAL: {{completeData.total + completeData.tax | currency}}</strong></div>

			<div class="separator"></div>
			<div class="col-xs-12 text-right">
				<a href="{{completeData.shop_url}}" class="btn btn-checkout">GO BACK TO SHOP</a>
			</div>
        </div>
    </div>
    
</div>