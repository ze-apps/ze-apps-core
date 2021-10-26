<?php

namespace Zeapps\Core;

use Zeapps\Core\Session;
use Zeapps\Models\User;

class Translation
{
    private $langToTransfert = [];
    private static $defaultLanguage = 'fr-FR' ;
    private static $lang = [];



    /***************** Singleton ****************/
    private static $_instance = null;
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new Translation();
        }
        return self::$_instance;
    }
    /***************** Fin : Singleton ****************/


    public function getLanguage() {
        if (count($this->langToTransfert) == 0) {
            self::loadLanguage();
            $this->langToTransfert = self::$lang ;
        }

        return $this->langToTransfert ;
    }

    public function getLanguageCurrentUser() {
        $language = self::$defaultLanguage ;

        $tokenUser = Session::get('token') ;
        if ($tokenUser != "") {
            $user = User::getUserByToken($tokenUser);
            if ($user) {
                $language = $user->lang ;
            }
        }

        return $language ;
    }





    public static function setLanguage($langCode) {
        self::$defaultLanguage = $langCode ;
    }

    public static function translate($key, $language = null)
    {
        // recupère les traductions
        self::$lang = self::getInstance()->getLanguage();

        if (!$language) {
            $language = self::getInstance()->getLanguageCurrentUser() ;
        }

        $translation = $key;

        if (isset(self::$lang[$language][$key])) {
            $translation = self::$lang[$language][$key];
        }

        return $translation;
    }

    public static function getJsArray() {
        self::$lang = self::getInstance()->getLanguage();

        return "var arrTranslateJSon = " . json_encode(self::$lang) . ";" ;
    }





    private static function loadLanguage()
    {
        // load language from System
        $langDir = SYSDIR . "lang/" ;
        self::getLanguageFromFolder($langDir);

        if (is_dir(MODULEPATH)) {
            if ($folderModule = opendir(MODULEPATH)) {
                while (false !== ($folderItem = readdir($folderModule))) {
                    $dir = MODULEPATH . $folderItem;
                    if (is_dir($dir) && $folderItem != '.'
                        && $folderItem != '..'
                    ) {
                        self::getLanguageFromFolder($dir . "/lang/");
                    }
                }
            }
        }
    }


    private static function getLanguageFromFolder($langDir)
    {
        if (is_dir($langDir)) {
            if ($folderLang = opendir($langDir)) {
                while (false !== ($folderItem = readdir($folderLang))) {
                    $langFile = $langDir . $folderItem;
                    if (is_file($langFile) && $folderItem != '.'
                        && $folderItem != '..'
                    ) {
                        $langCode = substr($folderItem, 0, strpos($folderItem, ".")) ;

                        $dataLanguage = require_once $langFile ;

                        if (!isset(self::$lang[$langCode])) {
                            self::$lang[$langCode] = array() ;
                        }

                        if (is_array($dataLanguage)) {
                            foreach ($dataLanguage as $key => $value) {
                                if (!isset(self::$lang[$langCode][$key])) {
                                    self::$lang[$langCode][$key] = $value ;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}