app.filter("trusted", ["$sce", function($sce){
	return function(html){
		if (html) {
			return $sce.trustAsHtml(html + "");
		} else {
			return "";
		}
	};
}]);