<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Zeapps\Core\Event;

class Hooks extends Controller
{
    public function get_all()
    {
        $retourJson = array() ;


        echo json_encode(Event::getHook());
    }
}