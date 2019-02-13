// declare the modal to the app service
listModuleModalFunction.push({
    module_name:"com_zeapps_core",
    function_name:"form_modal",
    templateUrl:"/zeapps/directives/form_modal",
    controller:"ZeAppsCoreModalFormCtrl",
    size:"lg",
    resolve:{}
});

app.controller("ZeAppsCoreModalFormCtrl", ["$scope", "$uibModalInstance", "option", function($scope, $uibModalInstance, option) {

    $scope.title = option.title || "Création" ;
    $scope.form = option.edit || {};
    $scope.template = option.template;

    $scope.save = save;
    $scope.cancel = cancel;

    function save() {

        if ($scope.form.zeapps_modal_form_isvalid) {
            delete $scope.form.zeapps_modal_form_isvalid;
        }

        if ($scope.form.zeapps_modal_form_custom_isvalid) {
            delete $scope.form.zeapps_modal_form_custom_isvalid;
        }

        $uibModalInstance.close($scope.form);
    }

    function cancel() {
        $uibModalInstance.dismiss("cancel");
    }

}]) ;