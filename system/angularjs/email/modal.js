// declare the modal to the app service
listModuleModalFunction.push({
    module_name:'zeapps',
    function_name:'email_writer',
    templateUrl:'/zeapps/email/send_email',
    controller:'ComZeappsSendEmailCtrl',
    size:'lg',
    resolve:{
        titre: function () {
            return 'Envoyer un email';
        }
    }
});


app.controller('ComZeappsSendEmailCtrl', ["$scope", "$uibModalInstance", "$http", "titre", "option", function($scope, $uibModalInstance, $http, titre, option) {
    $scope.titre = titre ;


    $scope.attachments = [];

    $scope.form = {};

    if (option.subject) {
        $scope.form.subject = option.subject ;
    }

    if (option.content) {
        $scope.form.content = option.content ;
    }

    $scope.attachments = [] ;
    if (option.attachments) {
        $scope.attachments = option.attachments ;
    }


    $scope.modules = [] ;
    if (option.modules) {
        $scope.modules = option.modules ;
    }




    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };

    $scope.send = function () {
        var data = {};

        //data.id = $scope.quote.id;
        data.subject = $scope.form.subject;
        data.content = $scope.form.content;
        data.to = $scope.form.to ;
        data.attachments = $scope.attachments ;
        data.modules = $scope.modules ;

        var formatted_data = angular.toJson(data);


        $http.post("/zeapps/email/send_email_post", formatted_data).then(function(response){
            if(response.data && response.data != "false"){
                $uibModalInstance.close("ok");
            }
        });
    };

}]) ;