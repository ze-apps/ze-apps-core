<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;
use Zeapps\Core\Storage;
use Zeapps\Core\Mail;

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

    public function send_email()
    {
        $data = array();
        return view("email/send_email", $data);
    }

    public function sendEmailPost() {
        // constitution du tableau
        $data = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }





        $html = "<html><body>" . nl2br($data["content"]) . "</body></html>";
        $text = $data["content"];
        $sender = array() ;//array("name" => "Nicolas Ramel", "email" => "nicolas.ramel@preview-communication.fr");


        $data["to"] = str_replace(";", ",", $data["to"]);
        $tos = explode(",", $data["to"]);


        $to = array() ;//array(array("name" => "Nicolas Ramel", "email" => "nicolas.ramel@preview-communication.fr"));
        foreach ($tos as $to_data) {
            $to_data = trim($to_data) ;
            if (filter_var($to_data, FILTER_VALIDATE_EMAIL)) {
                $to[] = array("email" => $to_data) ;
            }
        }


        $cc = array();
        $bcc = array();



        $attachment = array();
        if (isset($data["attachments"]) && is_array($data["attachments"])) {
            foreach ($data["attachments"] as $attach) {
                $attachment[] = array(
                    'content' => Storage::getFileBase64($attach["file"]),
                    'name' => $attach["name"]
                );
            }
        }


        $emailModule = array();
        if (isset($data["modules"]) && is_array($data["modules"])) {
            $emailModule = $data["modules"] ;
        }




        Mail::send($data["subject"],
            $html,
            $text,
            $sender,
            $to,
            $bcc, // Bcc
            $cc, // Cc
            $attachment, // Attachment
            -1, // $id_user_account
            $emailModule
        );

        echo json_encode("ok");
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


    public function cron() {
        echo "test" ;
    }
}