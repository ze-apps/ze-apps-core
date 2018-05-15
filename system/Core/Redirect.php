<?php

namespace Zeapps\Core;

use Zeapps\Core\iResponse;
use Zeapps\Core\Routeur;

class Redirect implements iResponse
{
    private $_route = "" ;

    public function __construct($route, $params = array()) {
        if (Routeur::getByName($route)) {
            $this->_route = Routeur::getRouteByName($route, $params);
        } else {
            $this->_route = $route ;
        }
    }

    public function sendResponse($codeHTTP = 301) {
        header("Location:" . $this->_route);
        exit();
    }
}