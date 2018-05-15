<?php

namespace Zeapps\Core;

class Request
{
    private $dataRoute = array() ;

    public function input($name, $default = "") {
        if (isset($this->dataRoute[$name])) {
            return $this->dataRoute[$name] ;
        } elseif (isset($_GET[$name])) {
            return $_GET[$name] ;
        } elseif (isset($_POST[$name])) {
            return $_POST[$name] ;
        }

        return $default ;
    }

    public function setInputRoute($name, $value) {
        $this->dataRoute[$name] = $value ;
    }

    public function getMethod() {
        return strtolower($_SERVER["REQUEST_METHOD"]) ;
    }
}