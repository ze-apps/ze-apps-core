app.directive("zeModalsearchBtn", ["zeapps_modal", function (zeapps_modal) {

    return {
        restrict: "A",
        scope: {
            zeModalsearchBtn: '&',
            http: '=',
            fields: '=',
            model: '=',
            filters: '=',
            templateNew: '=',
            title: '@',
            onloadmodal: '=',
            onloadmodalparam: '='
        },
        template: function(elm, attrs){
            var color = attrs.color || "primary";
            var fa = attrs.fa || "font-awesome";
            var hint = attrs.hint || "...";
            var direction = attrs.direction || "right";
            var alwaysOn = attrs.alwaysOn || false;

            var html = 	"<button type='button' class='btn btn-xs btn-"+color+"' ng-click='openModal()'>";

            if(alwaysOn){
                if(direction === "right"){
                    html += "<i class='fas fa-fw fa-"+fa+"'></i> " + hint;
                } else {
                    html += hint + " <i class='fas fa-fw fa-"+fa+"'></i>";
                }
                html += "</button>";
            } else {
                html += "<i class='fa fa-fw fa-"+fa+"'></i></button>" +
                    "<span class='hover-hint-wrap hover-hint-"+direction+" hover-hint-"+color+"'><span class='hover-hint'>"+hint+"</span></span>";
            }

            return html ;
        },
        link: function ($scope) {
            $scope.openModal = openModal;

            function openModal() {
                var options = {
                    http: $scope.http,
                    fields: $scope.fields,
                    title: $scope.title,
                    filters: $scope.filters,
                    template: $scope.templateNew
                };

                if ($scope.onloadmodal) {
                    if ($scope.onloadmodalparam) {
                        $scope.onloadmodal($scope.onloadmodalparam);
                    } else {
                        $scope.onloadmodal();
                    }
                }

                zeapps_modal.loadModule("com_zeapps_core", "search_modal", options, function (objReturn) {
                    if (objReturn.id !== undefined) {
                        if ($scope.zeModalsearchBtn() instanceof Function) {
                            $scope.zeModalsearchBtn()(objReturn);
                        } else {
                            $scope.model = objReturn[$scope.zeModalsearchBtn()];
                        }
                    } else {
                        var formatted_data = angular.toJson(objReturn);
                        $scope.http.save(formatted_data).then(function (response) {
                            if (response.data && response.data != "false") {
                                objReturn.id = response.data;

                                if ($scope.zeModalsearchBtn() instanceof Function) {
                                    $scope.zeModalsearchBtn()(objReturn);
                                } else {
                                    $scope.model = objReturn[$scope.zeModalsearchBtn()];
                                }
                            }
                        })
                    }
                });
            }
        }
    };
}]);