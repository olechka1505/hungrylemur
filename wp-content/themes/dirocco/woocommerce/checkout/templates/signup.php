<div class="col-xs-12">
    <form class="col-md-3 col-xs-12 align-center checkout-form checkout-signup" ng-submit="signup()">
        <h3 class="checkout-form-title">REGISTER</h3>
        <div class="form-group">
            <input ng-model="signupData.login" class="form-control" type="email" placeholder="Email address"/>
        </div>
        <div class="form-group">
            <input ng-model="signupData.password" class="form-control" type="password" placeholder="Password"/>
        </div>
        
        <div class="form-group">
            <input ng-model="signupData.confirmPassword" class="form-control" type="password" placeholder="Confirm Password"/>
        </div>

        <div class="form-group">
            <input class="btn btn-block btn-checkout" type="submit" value="CONTINUE"/>
        </div>

        <div class="form-group clearfix">
            <a ui-sref="login" class="pull-right">CLICK HERE TO LOGIN</a>
        </div>
    </form>
</div>