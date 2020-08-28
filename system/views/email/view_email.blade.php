<div class="modal-header">
    <h3 class="modal-title">@{{titre}}  (@{{ email.date_send | date:'dd/MM/yyyy HH:mm:ss' }})</h3>
</div>


<div class="modal-body">
    <form>
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __t("Sender") }}</label><br>
                    @{{ email.sender.email }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __t("Recipient") }}(s)</label>

                    <table class="table table-striped">
                        <tr ng-repeat="to in email.to track by $index">
                            <td>@{{ to.email }}</td>
                        </tr>
                    </table>

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __t("Message") }}</label>
                    <div ng-bind-html="email.content_text | nl2br"></div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __t("Attachment(s)") }}</label>
                    <table class="table table-striped">
                        <tr ng-repeat="attachment in email.attachment track by $index">
                            <td><a ng-href="/@{{ attachment.file | trusted }}" target="_blank">
                                    @{{ attachment.name }}</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" type="button" ng-click="cancel()">{{ __t("Close") }}</button>
</div>
