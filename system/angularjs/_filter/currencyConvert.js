app.filter('currencyConvert', ["$sce", function($sce){
    return function(amount) {
        var currency = "EUR";
        if (zeappsLocalCurrency) {
            currency = zeappsLocalCurrency ;
        }

        var lang = "fr-FR";
        if (zeappsLocalDate) {
            lang = zeappsLocalDate ;
        }

        return (amount == null) ? 
            amount : 
            new Intl.NumberFormat(lang, { style: 'currency', currency: currency }).format(amount);
        ;
    }
}]);