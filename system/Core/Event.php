<?php

namespace Zeapps\Core;

use Cache\ObserverCache ;

class Event
{
    public static function sendAction($transmitterClassName = '', $actionName = '', $arrayParam = array(), $callBack = null) {
        $observers = ObserverCache::getObserver() ;

        foreach ($observers as $observer) {
            $observer::action($transmitterClassName, $actionName , $arrayParam, $callBack);
        }
    }
}