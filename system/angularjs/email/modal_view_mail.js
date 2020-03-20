// declare the modal to the app service
listModuleModalFunction.push({
    module_name: 'zeapps',
    function_name: 'email_viewer',
    templateUrl: '/zeapps/email/view_email',
    controller: 'ComZeappsViewEmailCtrl',
    size: 'lg',
    resolve: {
        titre: function () {
            return 'Envoyer un email';
        }
    }
});


app.controller('ComZeappsViewEmailCtrl', ["$scope", "$uibModalInstance", "$http", "titre", "option", "Upload", '$timeout',
    function ($scope, $uibModalInstance, $http, titre, option, Upload, $timeout) {
        $scope.titre = "";

        $scope.email = {};

        if (option.email) {
            $scope.email = option.email;

            $scope.titre = $scope.email.subject ;
        }

        console.log($scope.email);

        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);