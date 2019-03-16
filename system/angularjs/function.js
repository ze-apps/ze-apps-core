function zeappsBroadcast() {

    var listFunctionBroadcast = [];

    this.on = function (name, varFunction) {
        listFunctionBroadcast.push({"name": name, "varFunction": varFunction});
    };

    this.emit = function (name, valueObject) {
        for (var i = 0; i < listFunctionBroadcast.length; i++) {
            if (listFunctionBroadcast[i].name == name) {
                listFunctionBroadcast[i].varFunction(name, valueObject) ;
            }
        }
    };

}

var zeappsBroadcast = new zeappsBroadcast();