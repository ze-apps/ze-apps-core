<?php

namespace Zeapps\Console;

use Zeapps\Core\Translation;

class TranslateConsole
{
    public static function execute($argv = null) {
        $languages = Translation::getInstance()->getLanguage();


        // recherche dans le fichier VIEW (php) les textes qui n'ont pas été traduit
        if (is_dir(MODULEPATH)) {
            if ($folderModule = opendir(MODULEPATH)) {
                while (false !== ($folderItem = readdir($folderModule))) {
                    $dir = MODULEPATH . $folderItem;
                    if (is_dir($dir) && $folderItem != '.'
                        && $folderItem != '..'
                    ) {
                        self::scanDir($dir . "/views/", $folderItem, $languages);
                    }
                }
            }
        }
    }

    private static function scanDir($dossier, $module, &$languages) {
        if (is_dir($dossier)) {
            if ($folderModule = opendir($dossier)) {
                while (false !== ($folderItem = readdir($folderModule))) {
                    $dir = $dossier . $folderItem . "/";
                    if (is_dir($dir) && $folderItem != '.'
                        && $folderItem != '..'
                    ) {
                        self::scanDir($dir, $module, $languages);
                    } elseif ($folderItem != '.' && $folderItem != '..'
                    ) {
                        if (self::endsWith($dossier . $folderItem, '.php')) {
                            $contenuFichier = file_get_contents($dossier . $folderItem) ;
                            $retour = self::getTagValue($contenuFichier);
                            if (count($retour)) {
                                foreach ($retour as $toTranslate) {
                                    $firstKey = array_key_first($languages) ;
                                    if (!isset($languages[$firstKey][$toTranslate])) {
                                        echo $toTranslate . "\n" ;

                                        // TODO : modifier les fichiers de traduction du module
                                        // dans le dossier /lang du module
                                        // recréer le tableau php mais il faut pouvoir le livre et récupérer les anciennes valeurs dedans
                                        // et actualiser la variable : $languages
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    private static function getTagValue($string)
    {
        $result = [] ;

        $pattern = "/__t\(\"(.*?)\"\)/s";
        preg_match_all($pattern, $string, $matches);

        if (isset($matches[1]) && count($matches[1])) {
            foreach ($matches[1] as $match) {
                $result[] = $match ;
            }
        }

        return $result;
    }




    private static function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }
}