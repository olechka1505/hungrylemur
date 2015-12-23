<div class="col-xs-12">
    <div class="col-md-4 col-xs-12 align-center">
        <h3 class="checkout-form-title text-center">REVIEW & SUBMIT</h3>
    </div>

    <table class="checkout-confirm-table">
        <tr ng-repeat="product in confirmData.products">
            <td><img ng-src="{{product.image}}" alt=""></td>
            <td class="text-center">{{product.name}}</td>
            <td class="text-center">{{product.name}}</td>
            <td class="text-right">{{product.price | currency}}</td>
        </tr>
    </table>

    <div class="col-md-3 col-xs-12 pull-right">
        <div ng-if="confirmData.shipping.standard" class="text-right"><strong>SHIPPING: FREE</strong></div>
        <div ng-if="confirmData.shipping.expedited" class="text-right"><strong>SHIPPING: +$40</strong></div>
        <div class="text-right"><strong>TAX: {{confirmData.tax | currency}}</strong></div>
    </div>


    <div class="separator"></div>
    <div class="separator"></div>

    <div class="col-xs-12 text-right">
        <input type="button" ng-click="confirm()" class="btn btn-checkout" value="SUBMIT ORDER">
    </div>
</div>