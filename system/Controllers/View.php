<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Zeapps\Models\User;

class View extends Controller
{
    public function directive_zefilter() {
        $data = array();
        return view("directives/zefilter", $data);
    }

}