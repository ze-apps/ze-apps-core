<?php

namespace Zeapps\Core;

use Cache\ObserverCache ;

class Event
{
    public static function sendAction($transmitterClassName = '', $actionName = '', &$arrayParam = array(), $callBack = null, $finalCallBack = null) {
        $observers = ObserverCache::getObserver() ;

        foreach ($observers as $observer) {
            $observer::action($transmitterClassName, $actionName , $arrayParam, $callBack);
        }
    }


    public static function getHook($callBack = null) {
        $observers = ObserverCache::getObserver() ;

        $listHooks = array();

        foreach ($observers as $observer) {
            $retour = $observer::getHook();

            if (is_array($retour)) {
                $listHooks = array_merge($listHooks, $retour);
            }
        }

        return $listHooks ;
    }


    public static function getCron($callBack = null) {
        $observers = ObserverCache::getObserver() ;

        $listCron = array();

        foreach ($observers as $observer) {
            $retour = $observer::getCron();

            if (is_array($retour)) {
                $listCron = array_merge($listCron, $retour);
            }
        }

        return $listCron ;
    }
}