<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Zeapps\Models\User as UserModel;
use Zeapps\Models\UserGroups;
use Zeapps\Models\Groups;
use Zeapps\Models\Module;
use Zeapps\Models\ModuleRights;
use Zeapps\Models\Token ;

use Zeapps\Core\Right;

class Group extends Controller
{
    public function modal_group()
    {
        $data = array();
        return view("group/modal", $data);
    }

    public function view()
    {
        $data = array();
        return view("group/view", $data);
    }

    public function form()
    {
        $data = array();
        return view("group/form", $data);
    }


    public function get(Request $request)
    {
        $id = $request->input('id', 0);

        if ($user = UserModel::where('id', $id)->first()) {
            $groupsData = array() ;
            if ($user_groups = UserGroups::where('id_user', $user->id)->get()) {
                foreach ($user_groups as $user_group) {
                    $groupsData[$user_group->id_group] = true;
                }
            }

            $user->groups = $groupsData;
        }

        if (!$groups = Groups::orderBy('label')->get()) {
            $groups = [];
        }

        if ($modules = Module::getActiveModule()) {
            foreach ($modules as $module) {
                $rights = ModuleRights::where('id_module', $module->id)->get();
                if ($rights && count($rights)) {
                    $module->rights = json_decode($rights->rights, true);
                } else {
                    $module->rights = false;
                }
            }
        } else {
            $modules = [];
        }

        echo json_encode(array(
            'user' => $user,
            'groups' => $groups,
            'modules' => $modules
        ), true);
    }

    public function all()
    {
        if ($modules = Module::getActiveModule()) {
            foreach ($modules as $module) {
                $rights = [] ;
                foreach (Right::getInstance()->getRightModule($module->module_id) as $right) {
                    $rights[$right["id"]] = isset($right["label"])?$right["label"]:"" ;
                }

                if (count($rights)) {
                    $module->rights = $rights;
                } else {
                    $module->rights = false;
                }
            }
        } else {
            $modules = [];
        }

        echo json_encode(array(
            'groups' => Groups::all(),
            'modules' => $modules
        ));
    }


    public function save()
    {
        // constitution du tableau
        $data = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0
            && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        $group = new Groups() ;

        if (isset($data["id"]) && is_numeric($data["id"])) {
            $group = Groups::where('id', $data["id"])->first();
        }

        foreach ($data as $key => $value) {
            $group->$key = $value ;
        }
        $group->save() ;

        echo $group->id;
    }

    public function delete(Request $request)
    {
        $id = $request->input('id', 0);
        echo Groups::where('id', $id)->delete();
    }
}