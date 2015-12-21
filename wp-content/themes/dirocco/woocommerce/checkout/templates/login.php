<div class="col-xs-12">
    <form class="col-md-4 col-md-offset-4 col-xs-12" ng-submit="login()">
        <div class="form-group">
            <input ng-model="loginData.login" class="form-control" type="text" placeholder="Email address"/>
        </div>
        <div class="form-group">
            <input ng-model="loginData.password" class="form-control" type="password" placeholder="Password"/>
        </div>
        <a ui-sref="forgot" class="pull-right">Forgot Password?</a>
        <div class="form-group">
            <input class="btn btn-block" type="submit" value="Continue"/>
        </div>
        <a ui-sref="signup" class="pull-right">Click here to register</a>
    </form>
</div>