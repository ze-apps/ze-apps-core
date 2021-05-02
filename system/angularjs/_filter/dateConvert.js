app.filter('dateConvert', ["$sce", function($sce){
    return function(dateIso, param, caractereVide) {
        var dateATraiter = Date.parse(dateIso);

        var lang = "fr-FR";
        if (zeappsLocalDate) {
            lang = zeappsLocalDate ;
        }

        // la date n'est pas reconnue
        if (isNaN(dateATraiter)) {
            if (caractereVide) {
                return caractereVide ;
            } else {
                return "-" ;
            }
        } else {
            var options = {};
            if (param == "datetime") {
                options = {year: "numeric", month: "numeric", day: "numeric",
                hour: "numeric", minute: "numeric", second: "numeric"};
            } else if (param == "time") {
                options = {
                hour: "numeric", minute: "numeric", second: "numeric"};
            }

            return new Intl.DateTimeFormat(lang, options).format(dateATraiter);
        }
    }
}]);