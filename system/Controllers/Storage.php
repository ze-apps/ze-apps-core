<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Zeapps\Core\Storage as StorageHelper ;


class Storage extends Controller
{
    private $_modules = [];

    public function index(Request $request)
    {
        if (!StorageHelper::getFile($request->input("chemin"))) {
            return abort(404) ;
        }
    }
}