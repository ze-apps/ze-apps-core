<?php

namespace Zeapps\Observer;

use Zeapps\Core\iObserver ;
use Zeapps\Models\CronModel;

class EmailObserver implements iObserver
{
    public static function action($transmitterClassName = '', $actionName = '', $arrayParam = array(), $callBack = null) {

    }


    public static function getHook() {
        $retour = array();

        return $retour ;
    }


    public static function getCron() {
        $retour = array();

        // déclaration du cron
        $cron = new CronModel() ;
        $cron->command = "Zeapps\\Controllers\\Email@cron" ;
        $retour[] = $cron ;

        return $retour ;
    }
}