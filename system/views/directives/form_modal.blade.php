<div class="modal-header">
    <h3 class="modal-title">@{{::title}}</h3>
</div>

<div class="modal-body">
    <div ng-include="template"></div>
</div>

<div class="modal-footer">
    <button class="btn btn-danger btn-sm" type="button" ng-click="cancel()">{{ __t("Cancel") }}</button>
    <button class="btn btn-success btn-sm" type="button" ng-click="save()" ng-disabled='(form.zeapps_modal_form_isvalid != undefined && form.zeapps_modal_form_isvalid == false) || (form.zeapps_modal_form_custom_isvalid != undefined && form.zeapps_modal_form_custom_isvalid == false)' ng-hide="form.zeapps_modal_hide_save_btn">{{ __t("Confirm") }}</button>
</div>