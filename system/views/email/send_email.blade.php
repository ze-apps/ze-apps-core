<div class="modal-header">
    <h3 class="modal-title">@{{titre}}</h3>
</div>


<div class="modal-body">
    <form>
        <div class="row">


            <div class="col-md-12" ng-show="templates.length >= 1">
                <div class="form-group">
                    <label>{{ __t("Message template") }}</label><br>
                    <select ng-model="template_selected" ng-change="template_change()" class="form-control">
                        <option ng-value="-1">--</option>
                        <option ng-repeat="template in templates" ng-value="$index">@{{ template.name }}</option>
                    </select>
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __t("Sender") }}</label><br>
                    @{{user.firstname[0]}}. @{{user.lastname}} <@{{user.email}}>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __t("Recipient") }}(s)</label>
                    <div class="row">
                        <div class="col-xs-9">
                            <input type="text" class="form-control" ng-model="form.to_add"/>
                        </div>
                        <div class="col-xs-3">
                            <button type="button" class="btn btn-primary btn-sm" ng-click="add_email()">{{ __t("Add") }}</button>
                        </div>
                    </div>

                    <table class="table table-striped">
                        <tr ng-repeat="to in form.to track by $index">
                            <td>@{{ to }}</td>
                            <td class="text-right"><button type="button" class="btn btn-xs btn-danger" ng-click="removeTo($index)"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    </table>

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __t("Object") }}</label>
                    <input type="text" class="form-control" ng-model="form.subject"/>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __t("Message") }}</label>
                    <textarea class="form-control" ng-model="form.content" rows="10"></textarea>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __t("Attachment(s)") }}</label>

                    <button type="file" ngf-select="uploadFiles($file, $invalidFiles)" class="btn btn-success btn-xs"
                            {{-- accept="image/*" ngf-max-height="1000" ngf-max-size="1MB"--}}>
                        {{ __t("Add") }}
                    </button>
                    <br>
                    <div style="font:smaller">@{{errFile.$error}} @{{errFile.$errorParam}}
                        <span class="progress" ng-show="f.progress >= 0 && f.progress < 100">
                          <div style="width:@{{f.progress}}%"
                               ng-bind="f.progress + '%'"></div>
                      </span>
                    </div>
                    @{{errorMsg}}

                    <table class="table table-striped">
                        <tr ng-repeat="attachment in attachments track by $index">
                            <td><a ng-href="@{{ attachment.url | trusted }}"
                                                                         target="_blank">
                                    @{{ attachment.name }}</a></td>
                            <td class="text-right"><button type="button" class="btn btn-xs btn-danger" ng-click="removeFile($index)"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button class="btn btn-danger" type="button" ng-click="cancel()">{{ __t("Cancel") }}</button>
    <button class="btn btn-success" ng-click="send()">{{ __t("Send") }}</button>
</div>
