<?php

namespace Zeapps\Core;

use Brevo;
use GuzzleHttp;
use Config\Email as EmailConfig;

use Zeapps\Models\Email;
use Zeapps\Models\EmailModule;
use Zeapps\Models\EmailEvent;

use Zeapps\Models\User;

class Mail
{
    public static function getStatusLabel($idStatus) {
        switch ($idStatus) {
            case 1:
                return "sent";
                break;
            case 2:
                return "delivred";
                break;
            case 3:
                return "error";
                break;
        }

    }


    public static function send(
        $subject,
        $content_html = "",
        $content_text = "",
        $sender = array(),
        $to = array(),
        $bcc = array(),
        $cc = array(),
        $attachment = array(),
        $id_user_account = -1,
        $modules = array()
    )
    {
        $id_emailer = "" ;

        $name_user_account = "";
        $email_user = "";

        if ($id_user_account == -1 && Session::get('token')) {
            if ($user = User::getUserByToken(Session::get('token'))) {
                $id_user_account = $user->id;
                $name_user_account = $user->firstname . " " . $user->lastname;
                $email_user = $user->email;
            } else {
                $id_user_account = 0;
            }
        }

        if (!isset($sender["email"])) {
            $sender["email"] = $email_user;
        }


        // traitement des pièces jointes
        $attachmentSaveDB = array();
        if (count($attachment)) {
            foreach ($attachment as &$attach) {
                if (isset($attach["url"])) {
                    $handle = fopen($attach["url"], "rb");
                    if (FALSE === $handle) {
                        exit("Echec lors de l'ouverture du flux vers l'URL");
                    }

                    $contents = '';

                    while (!feof($handle)) {
                        $contents .= fread($handle, 8192);
                    }
                    fclose($handle);

                    $attach["content"] = base64_encode($contents);
                    unset($attach["url"]);
                }
            }


            // ecriture dans le dossier de storage / email
            foreach ($attachment as &$attach) {
                if (isset($attach["content"])) {
                    $attachmentSaveDB[] = array(
                        "file" => Storage::saveBase64($attach["content"], $attach["name"], "email"),
                        "name" => $attach["name"]
                    );
                }
            }
        }


        $config = Brevo\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', EmailConfig::$sendinblue_api_key_v3);


        $apiInstance = new Brevo\Client\Api\TransactionalEmailsApi(
        // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
        // This is optional, `GuzzleHttp\Client` will be used as default.
            new GuzzleHttp\Client(),
            $config
        );


        $sendSmtpEmail = new \Brevo\Client\Model\SendSmtpEmail(); // \Brevo\Client\Model\SendSmtpEmail | Values to send a transactional email
        $sendSmtpEmail->setSubject($subject) ;
        $sendSmtpEmail->setHtmlContent($content_html) ;
        $sendSmtpEmail->setTextContent($content_text) ;
        $sendSmtpEmail->setSender($sender) ;
        if (count($to)) {
            $sendSmtpEmail->setTo($to);
        }

        if (count($bcc)) {
            $sendSmtpEmail->setBcc($bcc);
        }

        if (count($cc)) {
            $sendSmtpEmail->setBcc($cc);
        }

        if (count($attachment)) {
            $sendSmtpEmail->setAttachment($attachment);
        }


        try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
            $id_emailer = $result->getMessageId() ;

        } catch (\Exception $e) {
            echo 'Exception when calling SMTPApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
        }









        $email = new Email();
        $email->subject = $subject;
        $email->content_html = $content_html;
        $email->content_text = $content_text;
        $email->sender = json_encode($sender);
        $email->to = json_encode($to);
        $email->bcc = json_encode($bcc);
        $email->cc = json_encode($cc);
        $email->attachment = json_encode($attachmentSaveDB);
        $email->id_user_account = $id_user_account;
        $email->name_user_account = $name_user_account;
        $email->date_send = date("Y-m-d H:i:s");
        $email->tags = "";
        $email->status = 1;
        $email->id_emailer = $id_emailer;
        $email->save();

        foreach ($modules as $module) {
            $emailModule = new EmailModule();
            $emailModule->id_email = $email->id ;
            $emailModule->module = $module["module"];
            $emailModule->filtre_module = $module["id"];
            $emailModule->save() ;
        }
    }
}
