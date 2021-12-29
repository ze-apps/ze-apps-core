app.controller("ComZeappsEmailListPartialCtrl", ["$scope", "$routeParams", "$location", "$rootScope", "$http", 'zeapps_modal',
	function ($scope, $routeParams, $location, $rootScope, $http, zeapps_modal) {
		$scope.page = 1;
		$scope.pageSize = 15;
        $scope.total = 0;


        $scope.loadList = loadList;
        $scope.goTo = goTo;

        $scope.$on("ComZeappsEmailListPartialCtrlUpdateList", function (event, value) {
            loadList(true) ;
        });

		loadList(true) ;

		function loadList(context) {
            $http.get("/zeapps/email/filtre/" + $scope.module + "/" + $scope.id).then(function (response) {
				if (response.status == 200) {
                    angular.forEach(response.data.emails, function (email) {
                        email.attachment = angular.fromJson(email.attachment);
                        email.bcc = angular.fromJson(email.bcc);
                        email.cc = angular.fromJson(email.cc);
                        email.sender = angular.fromJson(email.sender);
                        email.to = angular.fromJson(email.to);

                        email.date_send = new Date(email.date_send);
                    });

                    $scope.emails = angular.fromJson(response.data.emails);
                    $scope.total = response.data.total;
				}
			});
		}

        function goTo(email){
		    var options = {};
            options.email = email ;
            zeapps_modal.loadModule("zeapps", "email_viewer", options, function (objReturn) {
                if (objReturn) {
                }
            });
        }

	}]);