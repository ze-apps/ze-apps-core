<div class="modal-header">
    <h3 class="modal-title">@{{titre}}</h3>
</div>


<div class="modal-body">
    <form>
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label>Expéditeur</label><br>
                    @{{user.firstname[0]}}. @{{user.lastname}} <@{{user.email}}>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Destinataire(s)</label>
                    <input type="text" class="form-control" ng-model="form.to"/>
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
                    <ul>
                        <li ng-repeat="attachment in attachments"><a ng-href="@{{ attachment.url | trusted }}"
                                                                     target="_blank">
                                @{{ attachment.name }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button class="btn btn-danger" type="button" ng-click="cancel()">Annuler</button>
    <button class="btn btn-success" ng-click="send()">Envoyer</button>
</div>
