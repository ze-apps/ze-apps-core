<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Event;


class Cron extends Controller
{
    public function execute()
    {
        $listCron = Event::getCron();

        foreach ($listCron as $cron) {

            $cronExecutable = true ;

            // Minutes
            if ($cron->minute != "*" && date("i") != $cron->minute) {
                $cronExecutable = false ;
            }

            // Heures
            if ($cron->hour != "*" && date("H") != $cron->hour) {
                $cronExecutable = false ;
            }

            // Jours
            if ($cron->day != "*" && date("d") != $cron->day) {
                $cronExecutable = false ;
            }

            // Mois
            if ($cron->month != "*" && date("m") != $cron->month) {
                $cronExecutable = false ;
            }

            // Jour de la semaine
            if ($cron->dayOfWeek != "*" && date("w") != $cron->dayOfWeek) {
                $cronExecutable = false ;
            }

            if ($cronExecutable) {
                list($controller, $method) = explode("@", $cron->command);
                $ctrl = new $controller;
                $ctrl->$method();
            }
        }
    }
}