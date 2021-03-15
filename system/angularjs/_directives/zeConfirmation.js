app.directive("zeConfirmation", ["$uibModal", function($uibModal){
	return {
	    priority: 1,
        terminal: true,
		restrict: "A",
		link: function($scope, elm, attrs) {
	        var msg = attrs.zeConfirmation || __t("Would you like to permanently delete this item?");
	        var clickAction = attrs.ngClick;

            elm.bind('click', function(event){
                event.stopPropagation();

                var modalInstance = $uibModal.open({
                    animation: true,
                    templateUrl: "/assets/angular/popupModalDeBase.html",
                    controller: "ZeAppsPopupModalDeBaseCtrl",
                    size: "lg",
                    resolve: {
                        titre: function () {
                            return __t("Warning");
                        },
                        msg: function () {
                            return msg;
                        },
                        action_danger: function () {
                            return __t("Cancel");
                        },
                        action_primary: function () {
                            return false;
                        },
                        action_success: function () {
                            return __t("To confirm");
                        }
                    }
                });

                modalInstance.result.then(
                    function (selectedItem) {
                        if (selectedItem.action === "success") {
                            $scope.$eval(clickAction)
                        }
                    }
                );
            });

            elm.removeAttr("ze-confirmation");
        }
	};
}]);