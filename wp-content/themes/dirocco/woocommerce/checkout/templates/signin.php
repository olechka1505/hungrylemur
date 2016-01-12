<div class="col-md-8 col-xs-12 col-md-offset-2">
    <form class="col-md-4 align-center col-xs-12 checkout-form checkout-login" ng-submit="signin()">
        <h3 class="checkout-form-title text-center">LOG IN</h3>
        <div class="form-group">
            <input ng-model="signinData.login" class="form-control" type="text" placeholder="Email address"/>
        </div>
        <div class="form-group">
            <input ng-model="signinData.password" class="form-control" type="password" placeholder="Password"/>
        </div>
        <a ui-sref="forgot" class="pull-right">FORGOT PASSWORD?</a>
        <div class="form-group">
            <input class="btn btn-block btn-checkout" type="submit" value="CONTINUE"/>
        </div>
        <div class="form-group clearfix">
            <a ui-sref="signup" class="pull-right">CLICK HERE TO REGISTER</a>
        </div>
    </form>
</div>