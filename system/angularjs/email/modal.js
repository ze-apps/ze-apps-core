// declare the modal to the app service
listModuleModalFunction.push({
    module_name: 'zeapps',
    function_name: 'email_writer',
    templateUrl: '/zeapps/email/send_email',
    controller: 'ComZeappsSendEmailCtrl',
    size: 'lg',
    resolve: {
        titre: function () {
            return __t('Send an email');
        }
    }
});


app.controller('ComZeappsSendEmailCtrl', ["$scope", "$uibModalInstance", "$http", "titre", "option", "Upload", '$timeout',
    function ($scope, $uibModalInstance, $http, titre, option, Upload, $timeout) {
        $scope.titre = titre;

        var default_to = [];
        var default_subject = "";
        var default_content = "";
        var default_attachments = [];


        $scope.form = {};

        if (option.subject) {
            $scope.form.subject = option.subject;
            default_subject = option.subject;
        }

        if (option.content) {
            $scope.form.content = option.content;
            default_content = option.content;
        }

        $scope.form.to = [];
        if (option.to) {
            $scope.form.to = option.to;
        }
        angular.forEach(option.to, function (to_contact) {
            default_to.push(to_contact);
        });


        $scope.attachments = [];
        if (option.attachments) {
            $scope.attachments = option.attachments;
        }

        angular.forEach(option.attachments, function (attachment) {
            default_attachments.push(attachment);
        });


        $scope.modules = [];
        if (option.modules) {
            $scope.modules = option.modules;
        }


        $scope.template_change = function () {
            $scope.attachments = [];
            angular.forEach(default_attachments, function (attachment) {
                $scope.attachments.push(attachment);
            });

            $scope.form.to = [];
            /*angular.forEach(default_to, function (to_contact) {
                $scope.form.to.push(to_contact);
            });*/

            if ($scope.template_selected >= 0) {
                var template = $scope.templates[$scope.template_selected];
                var subject = template.subject;
                var content = template.message;

                // remplacement des tags par les valeurs transmises
                angular.forEach($scope.data_templates, function (data_template) {
                    subject = subject.replace(data_template.tag, data_template.value);
                    content = content.replace(data_template.tag, data_template.value);
                });

                $scope.form.subject = subject;
                $scope.form.content = content;

                angular.forEach(template.attachments, function (attachment) {
                    $scope.attachments.push({file: attachment.path, url: "/" + attachment.path, name: attachment.name});
                });

                if (template.default_to.trim() != "") {
                    var tab_to = template.default_to.split(",");
                    angular.forEach(tab_to, function (to_contact) {
                        if (to_contact.trim() != "") {
                            $scope.form.to.push(to_contact.trim());
                        }
                    });
                }

            } else {
                $scope.form.subject = default_subject;
                $scope.form.content = default_content;
            }
        };

        $scope.data_templates = [];
        if (option.data_templates) {
            $scope.data_templates = option.data_templates;
        }

        $scope.template_selected = -1;
        $scope.templates = [];
        if (option.templates) {
            $scope.templates = option.templates;

            var indexTemplate = -1 ;
            angular.forEach($scope.templates, function(template) {
                indexTemplate++;
                if (template.default_template) {
                    $scope.template_selected = indexTemplate ;
                    $scope.template_change();
                }
            });
        }

        

        
        
        if (option.id_model_email) {
            var indexTemplate = -1 ;
            angular.forEach($scope.templates, function(template) {
                indexTemplate++;
                if (template.id && template.id == option.id_model_email) {
                    $scope.template_selected = indexTemplate ;
                    $scope.template_change();
                }
            });
        }


        $scope.removeFile = function (index) {
            $scope.attachments.splice(index, 1);
        };

        $scope.removeTo = function (index) {
            $scope.form.to.splice(index, 1);
        };

        $scope.add_email = function () {
            $scope.form.to.push($scope.form.to_add);
            default_to.push($scope.form.to_add);
            $scope.form.to_add = "";
        };


        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

        $scope.send = function () {
            var data = {};

            //data.id = $scope.quote.id;
            data.subject = $scope.form.subject;
            data.content = $scope.form.content;
            data.to = $scope.form.to;
            data.attachments = $scope.attachments;
            data.modules = $scope.modules;

            var formatted_data = angular.toJson(data);

            $http.post("/zeapps/email/send_email_post", formatted_data).then(function (response) {
                if (response.data && response.data != "false") {
                    $uibModalInstance.close("ok");
                }
            });
        };


        $scope.uploadFiles = function (file, errFiles) {
            $scope.f = file;
            $scope.errFile = errFiles && errFiles[0];
            if (file) {
                var nomFichier = file.name;

                file.upload = Upload.upload({
                    url: '/zeapps/email/file/upload',
                    data: {file: file}
                });

                file.upload.then(function (response) {
                    $timeout(function () {
                        file.result = response.data;

                        var attachment = {file: angular.fromJson(response.data), url: "/" + angular.fromJson(response.data), name: nomFichier};
                        $scope.attachments.push(attachment);
                        default_attachments.push(attachment);
                    });
                }, function (response) {
                    if (response.status > 0)
                        $scope.errorMsg = response.status + ': ' + response.data;
                }, function (evt) {
                    file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
                });
            }
        };

    }]);