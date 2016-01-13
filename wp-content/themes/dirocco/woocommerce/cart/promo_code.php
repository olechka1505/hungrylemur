<div class="separator"></div>
<div class="col-md-4 col-xs-12 no-padding text-right pull-right">
    <form method="POST" class="form promo-form">
        <?php wp_nonce_field( 'woocommerce_before_notices', 'promo_nonce' ); ?>
        <div class="promo-section">
            <div class="col-md-9 col-xs-12">
                <input name="promo" type="text" class="form-control" placeholder="Promo Code">
            </div>
            <div class="col-md-3 col-xs-12">
                <input type="submit" class="btn btn-promo-apply" value="APPLY">
            </div>
        </div>
    </form>
</div>
