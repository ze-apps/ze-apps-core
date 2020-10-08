<div ng-controller="ComZeappsEmailListPartialCtrl">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover table-condensed table-responsive" ng-show="emails.length">
                <thead>
                <tr>
                    <th>{{ __t("Recipient") }}</th>
                    <th>{{ __t("Object") }}</th>
                    <th>{{ __t("Date") }}</th>
                    <th>{{ __t("Sender") }}</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="email in emails">
                    <td ng-click="goTo(email)">
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            <li ng-repeat="to in email.to">@{{ to.email }}</li>
                        </ul>
                    </td>
                    <td ng-click="goTo(email)">@{{ email.subject }}</td>
                    <td ng-click="goTo(email)">@{{ email.date_send | date:'dd/MM/yyyy HH:mm:ss' }}</td>
                    <td ng-click="goTo(email)">@{{ email.sender.email }}</td>
                    <td ng-click="goTo(email)">
                        <i class="fas fa-fw fa-clock" style="color:#d28d00" ng-show="email.status==1" title="Envoi en cours"></i>
                        <i class="fa fa-fw fa-envelope" style="color:#12955f" ng-show="email.status==2" title="Message envoyé"></i>
                        <i class="fas fa-envelope-open" style="color:#12955f" ng-show="email.status==4" title="Message ouvert"></i>
                        <i class="fa fa-fw fa-exclamation-triangle" style="color:#ce0000" ng-show="email.status==3" title="Erreur"></i>
                    </td>
                    <td class="text-right">

                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>