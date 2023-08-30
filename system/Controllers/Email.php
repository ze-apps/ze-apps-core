<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;
use Zeapps\Core\Storage;
use Zeapps\Core\Mail;

use Brevo;
use GuzzleHttp;
use Config\Email as EmailConfig;

use Zeapps\Core\Event;
use Zeapps\Models\EmailModule;
use Zeapps\Models\Email as EmailModel ;
use Zeapps\Models\EmailEvent;

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

    public function view_email()
    {
        $data = array();
        return view("email/view_email", $data);
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

        $tos = $data["to"];


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

    public function uploadFile() {
        $file = Storage::uploadFile($_FILES["file"], "", "", true);
        echo json_encode($file);
        exit();
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
        if (class_exists ( "Config\Email")) {
            $date = new \DateTime();
            $date->sub(new \DateInterval('P3D'));

            // met en erreur tous les mails qui ont plus de 3 jours
            EmailModel::where("status", 1)->where("date_send", "<", $date->format("Y-m-d H:i:s"))->update(["status" => 3]);


            // analyse les mails qui sont en attente
            $emails = EmailModel::whereIn("status", [1,2])->where("date_send", ">=", $date->format("Y-m-d H:i:s"))->get();

            if ($emails) {

                if (env('apiSendinblue')) {
                    $config = Brevo\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', env('apiSendinblue'));
                } else {
                    $config = Brevo\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', EmailConfig::$sendinblue_api_key_v3);
                }
                


                $apiInstance = new Brevo\Client\Api\TransactionalEmailsApi(
                // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
                // This is optional, `GuzzleHttp\Client` will be used as default.
                    new GuzzleHttp\Client(),
                    $config
                );

                foreach ($emails as $email) {
                    // pour récupérer les évenements sur un email
                    try {
                        $result = $apiInstance->getEmailEventReport(50, 0, null, null, null, null, null, null, $email->id_emailer, null);


                        if (get_class($result) == "Brevo\Client\Model\GetEmailEventReport") {
                            $events = $result->getEvents();

                            if ($events) {
                                foreach ($events as $event) {
                                    if ($email->status == 1 && $event->getEvent() == "delivered") {
                                        $email->status = 2;
                                        $email->save();
                                    }

                                    if ($event->getEvent() == "opened") {
                                        $email->status = 4;
                                        $email->save();
                                    }

                                    


                                    // recherche si l'évènement a déjà été mémorisé
                                    $emailEvent = EmailEvent::where("id_email", $email->id)->where("date_event", $event->getDate()->format("Y-m-d H:i:s"))->where("event", $event->getEvent())->first();


                                    // memorise evenement
                                    if (!$emailEvent) {
                                        $emailEvent = new EmailEvent();
                                        $emailEvent->id_email = $email->id;
                                        $emailEvent->date_event = $event->getDate()->format("Y-m-d H:i:s");
                                        $emailEvent->event = $event->getEvent();
                                        $emailEvent->save();
                                    }

                                }
                            }
                        }
                    } catch (\Exception $e) {
                        echo 'Exception when calling SMTPApi->getEmailEventReport: ', $e->getMessage(), PHP_EOL;
                    }
                }
            }
        }



        //echo "test" ;
    }
}