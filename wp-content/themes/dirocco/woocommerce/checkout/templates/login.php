<div class="col-xs-12">
    <form class="col-md-3 col-xs-12 align-center checkout-form checkout-login" ng-submit="login()">
        <h3 class="checkout-form-title">LOG IN</h3>
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
</div>