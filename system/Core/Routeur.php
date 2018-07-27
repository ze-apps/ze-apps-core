<?php

namespace Zeapps\Core;

use Zeapps\Core\Request;
use Zeapps\Core\Response;

class Routeur
{
    private static $uriArr = array();
    private $lastUri = null;


    public static function addRoute($methodVerb, $uri, $controllerMethod)
    {
        Routeur::$uriArr[] = array("methodVerb" => $methodVerb, "uri" => $uri, "controllerMethod" => $controllerMethod);

        $obj = new Routeur();
        $obj->lastUri = $uri;
        return $obj;
    }

    public static function get($uri, $controllerMethod)
    {
        return Routeur::addRoute("get", $uri, $controllerMethod);
    }

    public static function post($uri, $controllerMethod)
    {
        return Routeur::addRoute("post", $uri, $controllerMethod);
    }

    public static function put($uri, $controllerMethod)
    {
        return Routeur::addRoute("put", $uri, $controllerMethod);
    }

    public static function delete($uri, $controllerMethod)
    {
        return Routeur::addRoute("delete", $uri, $controllerMethod);
    }

    public static function any($uri, $controllerMethod)
    {
        Routeur::addRoute("get", $uri, $controllerMethod);
        Routeur::addRoute("post", $uri, $controllerMethod);
        Routeur::addRoute("put", $uri, $controllerMethod);
        return Routeur::addRoute("delete", $uri, $controllerMethod);
    }

    public static function match($protocols, $uri, $controllerMethod)
    {
        $last = null ;
        foreach ($protocols as $protocol) {
            $last = Routeur::addRoute(strtolower($protocol), $uri, $controllerMethod);
        }

        return $last ;
    }

    public function name($alias)
    {
        if ($this->lastUri) {
            foreach (Routeur::$uriArr as &$route) {
                if ($route["uri"] == $this->lastUri) {
                    $route["name"] = $alias;
                    break;
                }
            }
        } else {
            // TODO : gérer une exception
        }
    }

    public static function loadCtrl()
    {
        $url = $_SERVER['REQUEST_URI'] ;

        $trouve = false;
        foreach (Routeur::$uriArr as $route) {
            // TODO : verifier la methode de l'appel (get, post, put, delete) pour valider la bonne route
            if ($params = self::checkUrlRoute($route["uri"], $url)) {
                $request = new Request ;
                if (is_array($params) && count($params)) {
                    foreach ($params as $key => $param) {
                        $request->setInputRoute($key, $param);
                    }
                }

                $trouve = true;

                list($controller, $method) = explode("@", $route["controllerMethod"]);
                $ctrl = new $controller;
                Response::send($ctrl->$method($request));
            }
        }

        if (!$trouve) {
            Response::send(abort(404), 404);
        }
    }


    public static function getByName($name)
    {
        foreach (Routeur::$uriArr as $route => $param) {
            if (isset($param["name"]) && $param["name"] == $name) {
                return $param;
                break;
            }
        }

        // TODO : gérer une exception
    }

    public static function getRouteByName($name, $params = array()) {
        if ($route = self::getByName($name)) {
            $url = $route['uri'] ;
            foreach ($params as $key => $value) {
                $url = str_replace("{" . $key  . "}", $value, $url);
            }
            return $url ;
        }
    }


    private static function getParamFromUri($uri) {
        $myPattern = "#{[^}]*}#";
        $myString = $uri;
        preg_match_all($myPattern, $myString, $matches);
        return $matches[0];
    }

    private static function checkUrlRoute($route, $uri) {
        $params = self::getParamFromUri($route) ;

        if (count($params) == 0 && $route == $uri) {
            return true ;
        } elseif (count($params) != 0) {
            $myPattern = '#' . $route . '#';
            foreach ($params as $param) {
                $myPattern = str_replace($param, "(.*)", $myPattern);
            }

            preg_match_all($myPattern, $uri, $matches);
            if (count($matches[0])) {
                $dataParams = array();
                for ($i = 1; $i <= count($params); $i++) {
                    $nomVariable = str_replace("{", "", str_replace("}", "", $params[$i-1]));
                    $dataParams[$nomVariable] = $matches[$i][0];
                }
                return $dataParams;
            }
        }

        return false ;
    }
}