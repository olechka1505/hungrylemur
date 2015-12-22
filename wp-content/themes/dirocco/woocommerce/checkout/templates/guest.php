<div class="col-xs-12">
    <form class="col-md-3 col-xs-12 checkout-form align-center checkout-login" ng-submit="guest()">
        <h3 class="checkout-form-title text-center">YOUR EMAIL</h3>
        <div class="form-group">
            <input ng-model="guestData.email" class="form-control" type="text" placeholder="Email address"/>
        </div>
        <div class="form-group">
            <input class="btn btn-block btn-checkout" type="submit" value="CONTINUE"/>
        </div>
    </form>
</div>