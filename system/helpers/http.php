<?php

use Zeapps\Core\Routeur ;
use Zeapps\Core\View;
use Zeapps\Core\Redirect;

if (! function_exists('abort')) {
    function abort($code, $message = '', array $headers = [])
    {
        if ($code == '404') {
            return view('404');
        }
    }
}



if (! function_exists('route')) {
    function route($name, $params = array())
    {
        return Routeur::getRouteByName($name, $params) ;
    }
}


if (! function_exists('view')) {
    function view($name, $data = array(), $viewPath = BASEPATH . 'system/views/', $cachePath = BASEPATH . "tmp/")
    {
        return new View($name, $data, $viewPath, $cachePath);
    }
}

if (! function_exists('redirect')) {
    function redirect($route, $params = array())
    {
        return new Redirect($route, $params);
    }
}

