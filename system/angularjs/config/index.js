app.controller("ComZeAppsConfigCtrl", ["$scope", "$rootScope", "zeHttp", "menu",
	function ($scope, $rootScope, zhttp, menu) {

        menu("com_ze_apps_config", "com_ze_apps_config");

		$scope.emptyCache = emptyCache;
		$scope.success = success;
		$scope.languages = [];
		$scope.zeapps_default_language = null ;

		zhttp.app.language.all().then(function (response) {
            if (response.status == 200) {
                $scope.languages = response.data ;
            }
		});
		
		zhttp.config.get("zeapps_default_language").then(function (reponse) {
			if (reponse.data) {
			$scope.zeapps_default_language = reponse.data.value * 1 ;
			}
		});

		function emptyCache() {
			zhttp.get("/zeapps/config/emptyCache").then(function (response) {
				if (response.data && response.data != "false") {
					document.location.reload(true);
				}
			});
		}

		function success(){
			var data = {};
			data["id"] = "zeapps_debug";
			data["value"] = $rootScope.debug ? 1 : 0;
			var formatted_data = angular.toJson(data);
			zhttp.config.save(formatted_data);


			var data = {};
			data["id"] = "zeapps_default_language";
			data["value"] = $scope.zeapps_default_language;
			var formatted_data = angular.toJson(data);
			zhttp.config.save(formatted_data);
		}

	}]);