<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Zeapps\Core\Event;
use Zeapps\Models\EmailModule;
use Zeapps\Models\Email as EmailModel ;

class Email extends Controller
{
    public function list_partial()
    {
        $data = array();
        return view("email/list_partial", $data);
    }


    public function filtre(Request $request) {
        $id = $request->input('id', "");
        $module = $request->input('module', "");


        $emailModule = EmailModule::select("id_email")->where("module", $module)->where("filtre_module", $id)->get();

        $email_ids = [];
        if ($emailModule) {
            foreach ($emailModule as $emailId) {
                $email_ids[] = $emailId->id_email ;
            }
        }

        $emails = EmailModel::whereIn("id", $email_ids)->orderBy("date_send", "DESC")->get();


        echo json_encode(array(
            'emails' => $emails,
            'total' => count($emails)
        ));
    }
}