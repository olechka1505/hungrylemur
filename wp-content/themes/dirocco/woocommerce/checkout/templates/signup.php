<div class="col-xs-12">
    <form class="col-md-4 col-md-offset-4 col-xs-12" ng-submit="signup()">
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
            <input class="btn btn-block" type="submit" value="Continue"/>
        </div>
        <a ui-sref="login" class="pull-right">Click here to login</a>
    </form>
</div>