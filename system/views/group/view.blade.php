<div id="breadcrumb">Ze-apps > {{ __t("Groups") }}</div>
<div id="content">


    <div class="row">
        <div class="col-md-12 text-right">
            <button type="button" ng-click="create()" class="btn btn-xs btn-success">
                <i class="fa fa-fw fa-plus"></i> {{ __t("Group") }}
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-condensed table-striped table-group-rights">
                <thead>
                <tr>
                    <th>{{ __t("Rights") }}</th>
                    <th ng-repeat="group in groups" class="text-center">
                        @{{ group.label}} <br>
                        <ze-btn fa="edit" color="info" hint="{{ __t("Edit") }}" ng-click="edit(group)"></ze-btn>
                        <ze-btn fa="trash" color="danger" hint="{{ __t("Delete") }}" ze-confirmation ng-click="delete(group)"></ze-btn>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="module-cell">
                    <td colspan="@{{groups.length + 1}}">
                        {{ __t("Application") }}
                    </td>
                </tr>
                <tr>
                    <td>{{ __t("Administration") }}</td>
                    <td ng-repeat="group in groups" class="text-center">
                        <input type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="group.rights_array['zeapps_admin']" ng-change="save(group)">
                    </td>
                </tr>
                <tr ng-repeat-start="module in modules" ng-if="module.rights" class="module-cell">
                    <td colspan="@{{groups.length + 1}}" ng-click="module.closed = !module.closed">
                        <i class="fa fa-fw" ng-class="module.closed ? 'fa-plus' : 'fa-minus'"></i>
                        {{ __t("Module") }} : @{{::module.label}}
                    </td>
                </tr>
                <tr ng-repeat-end ng-repeat="(right, label) in module.rights" ng-hide="module.closed">
                    <td>@{{::label}}</td>
                    <td ng-repeat="group in groups" class="text-center">
                        <input type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="group.rights_array[right]" ng-change="save(group)">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>