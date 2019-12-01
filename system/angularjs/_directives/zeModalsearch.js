app.directive("zeModalsearch", ["zeapps_modal", function (zeapps_modal) {

    return {
        restrict: "A",
        scope: {
            zeModalsearch: '&',
            http: '=',
            fields: '=',
            model: '=',
            filters: '=',
            filtermodel: '=',
            labelbutton: '@',
            templateNew: '=',
            title: '@',
            onloadmodal: '=',
            onloadmodalparam: '='
        },
        template: "<div class=\"input-group\">" +
            "<input type=\"text\" ng-model=\"model\" class=\"form-control\" disabled>" +
            "<span class=\"input-group-btn\">" +
            "<button class=\"btn btn-default\" type=\"button\" ng-click=\"clear()\"" +
            "ng-show=\"model != '' && model != undefined\">x" +
            "</button>" +
            "<button class=\"btn btn-default\" type=\"button\" ng-click='openModal()'>{{labelbutton}}</button>" +
            "</span>" +
            "</div>",
        link: function ($scope) {
            $scope.openModal = openModal;
            $scope.clear = clear;

            if ($scope.labelButton == undefined) {
                $scope.labelbutton = "..." ;
            }

            function clear() {
                if ($scope.zeModalsearch() instanceof Function) {
                    $scope.zeModalsearch()(false);
                } else {
                    $scope.model = undefined;
                }
            }

            function openModal() {
                var options = {
                    http: $scope.http,
                    fields: $scope.fields,
                    title: $scope.title,
                    filters: $scope.filters,
                    filtermodel: $scope.filtermodel,
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
                        if ($scope.zeModalsearch() instanceof Function) {
                            $scope.zeModalsearch()(objReturn);
                        } else {
                            $scope.model = objReturn[$scope.zeModalsearch()];
                        }
                    } else {
                        var formatted_data = angular.toJson(objReturn);
                        $scope.http.save(formatted_data).then(function (response) {
                            if (response.data && response.data != "false") {
                                objReturn.id = response.data;

                                if ($scope.zeModalsearch() instanceof Function) {
                                    $scope.zeModalsearch()(objReturn);
                                } else {
                                    $scope.model = objReturn[$scope.zeModalsearch()];
                                }
                            }
                        })
                    }
                });
            }
        }
    };

}]);