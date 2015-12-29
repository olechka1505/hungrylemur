<div class="col-xs-12">
    <div class="col-md-4 col-xs-12 align-center">
        <h3 class="checkout-form-title text-center">Order #{{completeData.order_id}}</h3>
    </div>

    <table class="checkout-confirm-table">
        <tr ng-repeat="product in completeData.products">
            <td><img ng-src="{{product.image}}" alt=""></td>
            <td class="text-center">{{product.name}}</td>
            <td class="text-center">{{product.cat}}</td>
            <td class="text-center">{{product.qty}}</td>
            <td class="text-right">{{product.price | currency}}</td>
        </tr>
    </table>

    <div class="col-md-3 col-xs-12 pull-right">
        <div ng-if="completeData.subtotal" class="text-right"><strong ng-bind-html="'SUBTOTAL: ' + completeData.subtotal"></strong></div>
        <div ng-if="completeData.delivery.standard" class="text-right"><strong>SHIPPING: FREE</strong></div>
        <div ng-if="completeData.delivery.expedited" class="text-right"><strong>SHIPPING: +$40</strong></div>
        <div class="text-right"><strong>TAX: {{completeData.tax | currency}}</strong></div>
        <div ng-if="completeData.total" class="text-right"><strong>TOTAL: {{completeData.total | currency}}</strong></div>
    </div>

    <div class="separator"></div>
    <div class="separator"></div>

    <div class="col-xs-12 text-right">
        <a href="{{completeData.shop_url}}" class="btn btn-checkout">GO BACK TO SHOP</a>
    </div>
</div>