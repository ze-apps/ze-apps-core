<div id="breadcrumb">Ze-apps > {{ __t("Users") }}</div>
<div id="content">


    <form>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __t("First name") }}</label>
                    <input type="text" class="form-control" ng-model="form.firstname">
                </div>
            </div>

            <div class="col-md-6">

                <div class="form-group">
                    <label>{{ __t("Last name") }}</label>
                    <input type="text" class="form-control" ng-model="form.lastname">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __t("Email") }}</label>
                    <input type="text" class="form-control" ng-model="form.email">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __t("Password") }}</label>
                    <input type="password" class="form-control" ng-model="form.password">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __t("Hourly rate") }} (€)</label>
                    <input type="number" class="form-control" ng-model="form.hourly_rate">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __t("Language") }}</label><br>
                    <select ng-model="form.lang" class="form-control">
                        <option ng-repeat="language in languages" ng-value="language.language_code">@{{ language.name }}</option>
                    </select>
                </div>
            </div>
        </div>






        <div ng-repeat="hook in hooks">
            <div ng-include="hook.template"></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __t("Groups") }}</label>

                    <div ng-repeat="group in groups">
                        <input type="checkbox" ng-model="form.groups[group.id]"> @{{::group.label}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __t("Additional rights") }}</label>
                    <div class="user-form-rights">
                        <div>
                            <div ng-click="application_closed = !application_closed" class="bg-dark">
                                <i class="fa fa-fw" ng-class="module.closed ? 'fa-plus' : 'fa-minus'"></i>
                                {{ __t("Application") }}
                            </div>

                            <div ng-hide="application_closed">
                                <label>
                                    <input type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="form.rights_array['zeapps_admin']">
                                    {{ __t("Administration") }}
                                </label>
                            </div>
                        </div>
                        <div ng-repeat="module in modules" ng-if="module.rights">
                            <div ng-click="module.closed = !module.closed" class="bg-dark">
                                <i class="fa fa-fw" ng-class="module.closed ? 'fa-plus' : 'fa-minus'"></i>
                                {{ __t("Module") }} : @{{::module.label}}
                            </div>

                            <div ng-repeat="(right, label) in module.rights" ng-hide="module.closed">
                                <label>
                                    <input type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="form.rights_array[right]">
                                    @{{::label}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="text-center">
                    <button type="button" class="btn btn-warning btn-sm" ng-click="annuler()">{{ __t("Cancel") }}</button>
                    <button type="button" class="btn btn-success" ng-click="enregistrer()">{{ __t("Save") }}</button>
                </div>

            </div>
        </div>
    </form>

</div>