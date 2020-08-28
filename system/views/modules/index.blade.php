<div id="breadcrumb">Ze-apps > {{ __t("Modules") }}</div>
<div id="content">

    <div class="row">
        <div class="col-md-12">
            <h3>{{ __t("Modules installed") }}</h3>
        </div>
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>nom</th>
                    <th class="text-right">{{ __t("Version") }}</th>
                    <th class="text-right">{{ __t("Active") }}</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="module in modules | orderBy:'version'">
                    <td>@{{ module.label }}</td>
                    <td class="text-right">@{{ module.version }}</td>
                    <td class="text-right"><span class="fa pointer" ng-class="testIfActif(module)"
                                                 ng-click="toggleActivation(module)"></span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row" ng-show="modulesToUpdate.length > 0 || modulesToInstall.length > 0">
        <div class="col-md-12">
            <h3>{{ __t("Modules available for installation") }}</h3>
        </div>
        <div class="col-md-6" ng-show="modulesToUpdate.length > 0">
            <h4>Mises a jour</h4>
            <div class="checkbox" ng-repeat="module in modulesToUpdate">
                <label>
                    <input type="checkbox" ng-model="modulesForm[module.module_id]">
                    @{{module.label}}
                </label>
            </div>
        </div>
        <div class="col-md-6" ng-show="modulesToInstall.length > 0">
            <h4>{{ __t("New modules") }}</h4>
            <div class="checkbox" ng-repeat="module in modulesToInstall">
                <label>
                    <input type="checkbox" ng-model="modulesForm[module.module_id]">
                    @{{module.label}}
                </label>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <button class="btn btn-primary" ng-click="installModules()">{{ __t("Install the selected modules") }}</button>
        </div>
    </div>

</div>