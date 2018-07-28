<?php

namespace Zeapps\Core;

interface iObserver {

    /**
     * Action that the observerReceive
     *
     * @param  string $transmitterClassName
     * @param  string $actionName
     * @param  array $arrayParam
     */
    public static function action($transmitterClassName = '', $actionName = '', $arrayParam = array(), $callBack = null);


    /**
     * GetHook that the observerReceive
     *
     * @return array
     */
    public static function getHook();
}