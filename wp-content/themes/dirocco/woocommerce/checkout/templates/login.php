<div class="col-md-8 col-xs-12 col-md-offset-2">
    <form class="col-md-4 col-xs-12 checkout-form checkout-login" ng-submit="login()">
        <h3 class="checkout-form-title text-center">LOG IN</h3>
        <div class="form-group">
            <input ng-model="loginData.login" class="form-control" type="text" placeholder="Email address"/>
        </div>
        <div class="form-group">
            <input ng-model="loginData.password" class="form-control" type="password" placeholder="Password"/>
        </div>
        <a ui-sref="forgot" class="pull-right">FORGOT PASSWORD?</a>
        <div class="form-group">
            <input class="btn btn-block btn-checkout" type="submit" value="CONTINUE"/>
        </div>
        <div class="form-group clearfix">
            <a ui-sref="signup" class="pull-right">CLICK HERE TO REGISTER</a>
        </div>
    </form>
    <div class="col-md-4 col-xs-12 text-center checkout-or-section">
        <h3>OR</h3>
    </div>
    <div class="col-md-4 col-xs-12 checkout-form checkout-as-guest">
        <a ui-sref="guest">CHECKOUT AS GUEST</a>
    </div>
</div>