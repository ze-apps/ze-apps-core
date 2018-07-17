<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Zeapps\Models\User;
use Zeapps\Models\Groups;

class Search extends Controller
{
    public function searchFor() {
        // constitution du tableau
        $data = array();

        $echo = [];

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0
            && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        $search_terms = explode('+', $data);


        $echo['Ze-Apps'] = [];



        /*public function searchFor($terms = array()){
            $query = "SELECT * FROM zeapps_users WHERE ( 1 ";

            foreach($terms as $term){
                $query .= "AND (firstname LIKE '%".$term."%' OR lastname LIKE '%".$term."%' OR email LIKE '%".$term."%') ";
            }

            $query .= ") AND deleted_at IS NULL LIMIT 10";

            return $this->database()->customQuery($query)->result();
        }*/







        /*if($users = $this->user->searchFor($search_terms)){
            $echo['Ze-Apps']['Utilisateurs'] = [];
            foreach($users as $user){
                $echo['Ze-Apps']['Utilisateurs'][] = array(
                    'label' => $user->firstname . " " . $user->lastname . ($user->email !== "" ? " (" . $user->email .")" : ""),
                    'url' => "/ng/com_zeapps/users/view/".$user->id
                );
            }
        }

        if($groups = $this->groups->searchFor($search_terms)){
            $echo['Ze-Apps']['Groupes d\'utilisateurs'] = [];
            foreach($groups as $group){
                $echo['Ze-Apps']['Groupes d\'utilisateurs'][] = array(
                    'label' => $group->label,
                    'url' => "/ng/com_zeapps/groups"
                );
            }
        }*/

        if(sizeof($echo['Ze-Apps']) === 0){
            unset($echo['Ze-Apps']);
        }

        /*$this->trigger->set('global_search');
        $ret = $this->trigger->execute($search_terms);

        if(is_array($ret) && sizeof($ret) > 0){
            foreach($ret as $result){
                if(!is_array($result)){
                    $result = array($result);
                }

                if(sizeof(reset($result)) > 0)
                    $echo = array_merge($echo, $result);
            }
        }*/

        echo json_encode(array(
            "results" => $echo
        ));
    }
}