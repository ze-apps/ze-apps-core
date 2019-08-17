app.filter('weight', ["$sce", function($sce){
    return function(poids) {
        if (isNaN(poids)) {
            return "" ;
        } else {
            var unite = "g.";

            if (poids < 1000) {
                poids = poids * 1 ;
            } else if (poids < 1000000) {
                unite = "kg";
                poids = poids / 1000;
            } else {
                unite = "t.";
                poids = poids / 1000 / 1000;
            }

            return poids.toFixed(2) + " " + unite;
        }
    }
}]);