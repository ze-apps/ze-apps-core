app.directive("formButtons", ["$uibModal", "$location", function($uibModal, $location){
	return {
		restrict: "E",
		require: "^form",
		template:   "<div class='form-buttons'>" +
						"<div class='text-center'>" +
							"<button type='button' class='btn btn-sm btn-default' ng-click='cancel();zeapps_form_ctrl.$setPristine()'>Annuler</button>" +
							"<button type='button' class='btn btn-success' ng-disabled='zeapps_form_ctrl.$invalid' ng-click='success();zeapps_form_ctrl.$setPristine()'>Valider</button>" +
						"</div>" +
					"</div>",
		link: function(scope, element, attrs, formCtrl){
			element.parents("form").addClass("hasFormButtons");

			scope.zeapps_form_ctrl = formCtrl;

			scope.$on("$locationChangeStart", function(event, next){
				// Cancel default behavior if we have unsaved changes to the form
				if(!scope.zeapps_form_ctrl.$pristine) {
					event.preventDefault();

					// Hash destination
					if (next.indexOf($location.$$host) >= 0) {
						var posHost = next.indexOf($location.$$host);
						var path = next.substr(posHost + 1);
						next = path.substr(path.indexOf("/"));
					}

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
								return __t("Unsaved changes are in progress, what do you want to do?");
							},
							action_danger: function () {
								return __t("Exit without saving");
							},
							action_primary: function () {
								return __t("Stay on the page");
							},
							action_success: function () {
								return __t("Save and exit");
							}
						}
					});

					modalInstance.result.then(function (selectedItem) {
						if (selectedItem.action == "danger") {
							scope.zeapps_form_ctrl.$setPristine();
							$location.url(next);
						} else if (selectedItem.action == "primary") {

						} else if (selectedItem.action == "success") {
							scope.success();
							scope.zeapps_form_ctrl.$setPristine();
							$location.url(next);
						}
					});
				}
			});

		}
	};
}]);