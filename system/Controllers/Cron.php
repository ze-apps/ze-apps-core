<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Zeapps\Core\Event;


class Cron extends Controller
{
    public function execute()
    {
        $listCron = Event::getCron();

        // TODO : controller si la tâche doit être éxécutée

        foreach ($listCron as $cron) {
            list($controller, $method) = explode("@", $cron->command);
            $ctrl = new $controller;
            $ctrl->$method();
        }
    }
}