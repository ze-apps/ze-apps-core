<div ng-controller="ComZeappsEmailListPartialCtrl">
    <!--<div class="text-center" ng-show="total > pageSize">
        <ul uib-pagination total-items="total" ng-model="page" items-per-page="pageSize" ng-change="loadList()"
            class="pagination-sm" boundary-links="true" max-size="15"
            previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></ul>
    </div>-->

    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover table-condensed table-responsive" ng-show="emails.length">
                <thead>
                <tr>
                    <th>Destinataire</th>
                    <th>Objet</th>
                    <th>Date</th>
                    <th>Expéditeur</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="email in emails">
                    <td ng-click="goTo(email.id)">
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            <li ng-repeat="to in email.to">@{{ to.email }}</li>
                        </ul>
                    </td>
                    <td ng-click="goTo(email.id)">@{{email.subject}}</td>
                    <td ng-click="goTo(email.id)">@{{email.date_send}}</td>
                    <td ng-click="goTo(email.id)">@{{email.sender.email}}</td>
                    <td class="text-right">

                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!--<div class="text-center" ng-show="total > pageSize">
        <ul uib-pagination total-items="total" ng-model="page" items-per-page="pageSize" ng-change="loadList()"
            class="pagination-sm" boundary-links="true" max-size="15"
            previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></ul>
    </div>-->
</div>