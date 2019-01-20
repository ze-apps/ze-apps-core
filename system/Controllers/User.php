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

class User extends Controller
{
    public function modal_user()
    {
        $data = array();
        return view("user/modalUser", $data);
    }

    public function view()
    {
        $data = array();
        return view("user/view", $data);
    }

    public function form()
    {
        $data = array();
        return view("user/form", $data);
    }


    public function get(Request $request)
    {
        $id = $request->input('id', 0);

        if ($user = UserModel::where('id', $id)->first()) {
            $user->groups = [];
            if ($user_groups = UserGroups::where('id_user', $user->id)->get()) {
                foreach ($user_groups as $user_group) {
                    $user->groups[$user_group->id_group] = true;
                }
            }
        }

        if (!$groups = Groups::orderBy('label')->get()) {
            $groups = [];
        }

        if ($modules = Module::where('active', 1)->get()) {
            foreach ($modules as $module) {
                if ($right = ModuleRights::where('id_module', $module->id)->get()) {
                    $module->rights = json_decode($right->rights, true);
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
        ));
    }


    public function get_context()
    {
        if(!$groups = Groups::orderBy('label')->get()){
            $groups = [];
        }

        if($modules = Module::where('active', 1)->get()) {
            foreach($modules as $module){
                if($right = ModuleRights::where('id_module', $module->id)->get()) {
                    $module->rights = json_decode($right->rights, true);
                }
                else {
                    $module->rights = false;
                }
            }
        }
        else{
            $modules = [];
        }

        echo json_encode(array(
            'groups' => $groups,
            'modules' => $modules
        ));
    }

    public function all()
    {
        echo json_encode(User::all());
    }

    public function modal(Request $request)
    {
        $limit = $request->input('limit', 0);
        $offset = $request->input('offset', 0);

        $filters = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }


        $users_rs = UserModel::orderBy('lastname') ;
        foreach ($filters as $key => $value) {
            if (strpos($key, " LIKE")) {
                $key = str_replace(" LIKE", "", $key);
                $users_rs = $users_rs->where($key, 'like', '%' . $value . '%') ;
            } else {
                $users_rs = $users_rs->where($key, $value) ;
            }
        }

        $total = $users_rs->count();


        $users = $users_rs->limit($limit)->offset($offset)->get();

        if(!$users) {
            $users = array();
        }

        echo json_encode(array("data" => $users, "total" => $total));
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

        $user = new UserModel() ;

        if (isset($data["id"]) && is_numeric($data["id"])) {
            $user = UserModel::where('id', $data["id"])->first();
        }

        foreach ($data as $key => $value) {
            $user->$key = $value ;
        }
        $user->save() ;



        if(isset($data['groups']) && is_array($data['groups'])){
            foreach($data['groups'] as $id_group => $value){
                if($value){
                    if(!UserGroups::where('id_user', $user->id)->where('id_group', $id_group)->first()) {
                        $this->user_groups->insert(array(
                            'id_user' => $user->id,
                            'id_group' => $id_group
                        ));
                    }
                } else {
                    UserGroups::where('id_user', $user->id)->where('id_group', $id_group)->delete();
                }
            }
        }

        echo $user->id;
    }


    public function delete(Request $request)
    {
        $id = $request->input('id', 0);
        echo UserModel::where('id', $id)->delete();
    }


    public function getCurrentUser()
    {
        // verifie si la session est active
        if (Session::get('token')) {
            $user = UserModel::getUserByToken(Session::get('token'));
            if ($user && count($user) == 1) {
                $user->password = null;

                $user->i18n = [];

                echo json_encode($user);
            }
        }
    }
}