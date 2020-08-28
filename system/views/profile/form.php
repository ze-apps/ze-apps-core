<div id="breadcrumb">Ze-apps > {{ __t("Users") }}</div>
<div id="content">


    <div class="row">
        <div class="col-md-12">
            <form>

                <div class="form-group">
                    <label>{{ __t("First name") }}</label>
                    <input type="text" class="form-control" ng-model="form.firstname">
                </div>

                <div class="form-group">
                    <label>{{ __t("Last name") }}</label>
                    <input type="text" class="form-control" ng-model="form.lastname">
                </div>

                <div class="form-group">
                    <label>{{ __t("Email") }}</label>
                    <input type="text" class="form-control" ng-model="form.email">
                </div>

                <div class="form-group">
                    <label>{{ __t("Password") }}</label>
                    <input type="password" class="form-control" ng-model="form.password_field">
                </div>



                <div class="text-center">
                    <button type="button" class="btn btn-warning btn-sm" ng-click="annuler()">{{ __t("Cancel") }}</button>
                    <button type="button" class="btn btn-success" ng-click="enregistrer()">{{ __t("Save") }}</button>
                </div>

            </form>
        </div>
    </div>


</div>