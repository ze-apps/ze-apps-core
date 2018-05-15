<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Zeapps\Models\User;

class Notification extends Controller
{
    public function getAll()
    {
        if ($user = User::getUserByToken(Session::get('token'))) {
            $notifications = \Zeapps\Models\Notification::where("id_user", $user->id)->get()->toArray();
            if ($notifications && count($notifications)) {
                echo json_encode($notifications);
            }
        }
    }

    public function getAllUnread()
    {
        if ($user = User::getUserByToken(Session::get('token'))) {
            $notifications = \Zeapps\Models\Notification::where("read_state", 0)->where("id_user", $user->id)->get()->toArray();
            if ($notifications && count($notifications)) {
                echo json_encode($notifications);
            }
        }
    }


    public function seenNotification()
    {
        $data = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);

        }

        if ($data) {
            foreach ($data as $module) {
                for ($j = 0; $j < sizeof($module['notifications']); $j++) {

                    $notification = \Zeapps\Models\Notification::find($module['notifications'][$j]["id"]);
                    $notification->seen = $module['notifications'][$j]["seen"] ;
                    $notification->save() ;
                }
            }
        }
    }


    public function readNotification($id = null)
    {
        $res = false;

        if ($user = User::getUserByToken(Session::get('token'))) {
            if ($id) {
                $notification = \Zeapps\Models\Notification::find($id);
                if ($notification->id_user == $user->id) {
                    $notification->read_state = 1;
                    $notification->save();

                    $res = true;
                }
            }
        }
        echo json_encode(!!$res);
    }

    public function readAllNotificationFrom($module = null)
    {
        $res = false;

        if ($user = User::getUserByToken(Session::get('token'))) {
            if ($module) {
                $notifications = \Zeapps\Models\Notification::where("module", $module)->where("id_user", $user->id)->get() ;
                foreach ($notifications as $notification) {
                    $notification->read_state = 1 ;
                    $notification->save() ;
                    $res = true ;
                }
            }
        }
        echo json_encode(!!$res);
    }

}