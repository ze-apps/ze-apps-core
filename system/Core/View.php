<?php

namespace Zeapps\Core;

use Zeapps\Core\Blade;

class View implements iResponse
{
    private $_name = "" ;
    private $_data = array() ;
    private $_viewPath = "" ;
    private $_cachePath = "" ;

    public function __construct($name, $data = array(), $viewPath = BASEPATH . 'system/views/', $cachePath = BASEPATH . "tmp/") {
        $this->name = $name ;
        $this->_data = $data ;
        $this->_viewPath = $viewPath ;
        $this->_cachePath = $cachePath ;
    }


    public function sendResponse($codeHTTP = 200) {
        $blade = new Blade($this->_viewPath, $this->_cachePath);

        header("HTTP/1.1 " . $codeHTTP . " OK");
        echo $blade->make($this->name, $this->_data) ;
        exit();
    }

    public function getContent() {
        $blade = new Blade($this->_viewPath, $this->_cachePath);
        return $blade->make($this->name, $this->_data) ;
    }
}