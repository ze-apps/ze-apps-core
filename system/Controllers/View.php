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

    public function form_modal() {
        $data = array();
        return view("directives/form_modal", $data);
    }


    public function zepostits() {
        $data = array();
        return view("directives/zepostits", $data);
    }

    public function search_modal() {
        $data = array();
        return view("directives/search_modal", $data);
    }


}