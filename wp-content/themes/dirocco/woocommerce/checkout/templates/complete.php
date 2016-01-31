<div class="col-xs-12 text-center"">
    <h3>ORDER NUMBER: {{completeData.order_id}}</h3>
</div>
<div class="col-xs-12">
    <div class="col-md-4 col-md-offset-1 col-xs-12 checkout-details checkout-shipping-details">
        <div class="col-xs-11 no-padding">
            <h3 class="checkout-form-title text-left">SHIPPING ADDRESS</h3>
            <p>{{completeData.shipping.first_name}} {{completeData.shipping.last_name}}</p>
            <p ng-if="completeData.shipping.company">{{completeData.shipping.company}}</p>
            <p><span>{{completeData.shipping.address_1}}</span><span ng-if="completeData.shipping.suite">, {{completeData.shipping.suite}}</span></p>
            <p>{{completeData.shipping.city}}, {{completeData.shipping.state}}, {{completeData.shipping.postcode}}</p>
        </div>

        <div class="col-xs-12 checkout-title-separator clearfix no-padding">DELIVERY OPTIONS</div>

        <div class="col-xs-12 no-padding">
            <p>{{completeData.delivery.label}} - {{completeData.delivery.cost | currency}}</p>
        </div>

        <div class="col-xs-12 checkout-title-separator clearfix no-padding">CREDIT CARD</div>

        <div class="col-xs-12 no-padding">
            <p><strong>{{completeData.card.type}}: {{'****' + completeData.card.last4}}</strong></p>
        </div>
    </div>
	
    <div class="col-md-7 col-xs-12 checkout-product-summary">
        <table class="checkout-confirm-table">
            <tr ng-repeat="product in completeData.order_info.products">
                <td><img ng-src="{{product.image}}" alt=""></td>
                <td class="text-center">{{product.name}}</td>
                <td class="text-center">{{product.cat}}</td>
                <td class="text-center">{{product.qty}}</td>
                <td class="text-right">{{product.price | currency}}</td>
            </tr>
        </table>
        <div class="col-md-4 col-xs-12 text-right pull-right">
            <div ng-if="completeData.order_info.subtotal" class="text-right"><div ng-bind-html="'SUBTOTAL: ' + completeData.order_info.subtotal"></div>
                <div class="text-right">TAX: {{completeData.order_info.tax | currency}}</div>
                <div ng-if="completeData.order_info.shipping_total" class="text-right">SHIPPING: {{completeData.order_info.shipping_total | currency}}</div>
<!--                <div ng-if="completeData.order_info.coupons_total" class="text-right">COUPONS: -{{completeData.order_info.coupons_total | currency}}</div>-->
                <div ng-if="completeData.order_info.total" class="text-right">TOTAL: {{completeData.order_info.total | currency}}</div>

			<div class="separator"></div>
			<div class="col-xs-12 text-right">
				<a href="{{completeData.shop_url}}" class="btn btn-checkout">GO BACK TO SHOP</a>
			</div>
        </div>
    </div>
    
</div>