<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;

use Zeapps\Models\Config as ConfigModel ;


class Config extends Controller
{
    public function index()
    {
        $data = array();
        return view("config/index", $data);
    }



    public function get(Request $request)
    {
        $id = $request->input("id", 0);

        echo json_encode(ConfigModel::find($id));
    }

    public function save()
    {
        // constitution du tableau
        $data = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        if ($data && is_array($data)) {
            if (isset($data[0]) && is_array($data[0])) { // Multidimensionnal array, we are saving multiple config settings at once
                for ($i = 0; $i < sizeof($data); $i++) {
                    $config = ConfigModel::find($data[$i]['id']) ;
                    if (!$config) {
                        $config = new ConfigModel();
                    }

                    foreach ($data[$i] as $key => $value) {
                        $config->$key = $value;
                    }

                    $config->save() ;
                }
            } else {
                $config = ConfigModel::find($data['id']) ;
                if (!$config) {
                    $config = new ConfigModel();
                }

                foreach ($data as $key => $value) {
                    $config->$key = $value;
                }

                $config->save() ;
            }
        }

        echo json_encode('OK');
    }

    public function emptyCache()
    {
        clearCache();

        echo json_encode('OK');

    }


}