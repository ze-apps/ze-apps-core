<div class="modal-header">
    <h3 class="modal-title">@{{titre}}</h3>
</div>


<div class="modal-body">
    <form>
        <div class="row">


            <div class="col-md-12" ng-show="templates.length >= 1">
                <div class="form-group">
                    <label>Modèle de message</label><br>
                    <select ng-model="template_selected" ng-change="template_change()" class="form-control">
                        <option ng-value="-1">--</option>
                        <option ng-repeat="template in templates" ng-value="$index">@{{ template.name }}</option>
                    </select>
                </div>
            </div>


            <div class="col-md-12">
                <div class="form-group">
                    <label>Expéditeur</label><br>
                    @{{user.firstname[0]}}. @{{user.lastname}} <@{{user.email}}>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Destinataire(s)</label>
                    <div class="row">
                        <div class="col-xs-9">
                            <input type="text" class="form-control" ng-model="form.to_add"/>
                        </div>
                        <div class="col-xs-3">
                            <button type="button" class="btn btn-primary btn-sm" ng-click="add_email()">Ajouter</button>
                        </div>
                    </div>

                    <table class="table table-striped">
                        <tr>
                            <td>Email</td>
                            <td></td>
                        </tr>
                        <tr ng-repeat="to in form.to track by $index">
                            <td>@{{ to }}</td>
                            <td class="text-right"><button type="button" class="btn btn-xs btn-danger" ng-click="removeTo($index)"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    </table>

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Sujet</label>
                    <input type="text" class="form-control" ng-model="form.subject"/>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Message</label>
                    <textarea class="form-control" ng-model="form.content" rows="10"></textarea>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Pièce(s) jointe(s)</label>

                    <button type="file" ngf-select="uploadFiles($file, $invalidFiles)" class="btn btn-success btn-xs"
                            {{-- accept="image/*" ngf-max-height="1000" ngf-max-size="1MB"--}}>
                        Ajouter
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
                        <tr>
                            <td>Fichier</td>
                            <td></td>
                        </tr>
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
    <button class="btn btn-danger" type="button" ng-click="cancel()">Annuler</button>
    <button class="btn btn-success" ng-click="send()">Envoyer</button>
</div>
