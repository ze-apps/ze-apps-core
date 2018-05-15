<?php

namespace Zeapps\Core;

class Translation
{
    private static $defaultLanguage = 'fr' ;
    private static $lang = [];
    private static $langLoaded = false;


    public static function setLanguage($langCode) {
        self::$defaultLanguage = $langCode ;
    }

    public static function translate($key)
    {
        if (!self::$langLoaded) {
            self::loadLanguage();
        }



        $translation = $key;

        if (isset(self::$lang[self::$defaultLanguage][$key])) {
            $translation = self::$lang[self::$defaultLanguage][$key];
        }


        return $translation;
    }


    private static function loadLanguage()
    {
        self::$langLoaded = true ;


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