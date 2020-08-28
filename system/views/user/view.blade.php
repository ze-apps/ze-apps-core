<div id="breadcrumb">Ze-apps > {{ __t("Users") }}</div>
<div id="content">


    <div class="row">
        <div class="col-md-12 text-right">
            <a href="/ng/com_zeapps/users/view" class="btn btn-xs btn-success">
                <i class="fa fa-fw fa-plus"></i> {{ __t("User") }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-condensed table-responsive" ng-show="users.length">
                <thead>
                <tr>
                    <th>{{ __t("First name") }}</th>
                    <th>{{ __t("Last name") }}</th>
                    <th>{{ __t("Email") }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="user in users">
                    <td><a href="/ng/com_zeapps/users/view/@{{user.id}}">@{{user.firstname}}</a></td>
                    <td><a href="/ng/com_zeapps/users/view/@{{user.id}}">@{{user.lastname}}</a></td>
                    <td><a href="/ng/com_zeapps/users/view/@{{user.id}}">@{{user.email}}</a></td>
                    <td class="text-right">
                        <ze-btn fa="trash" color="danger" hint="{{ __t("Delete") }}" direction="left" ng-click="delete(user)" ze-confirmation></ze-btn>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


</div>