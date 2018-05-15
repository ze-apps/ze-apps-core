<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;

class Installer extends Controller
{
    public function index(Request $request)
    {
        if ($request->getMethod() == "post") {
            $data = array() ;
            $data['hostname'] = $request->input("hostname");
            $data['username'] = $request->input("username");
            $data['password'] = $request->input("password");
            $data['database'] = $request->input("database");

            $fichierConfig = view('installer/database', $data);

            if (!is_dir(BASEPATH . "config/")) {
                recursive_mkdir(BASEPATH . "config/") ;
            }

            file_put_contents(BASEPATH . "config/Database.php", $fichierConfig->getContent());

            return redirect('home');
        }


        return view('installer/index');
    }
}