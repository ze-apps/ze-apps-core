<?php

namespace Zeapps\Console;

use Mpdf\Tag\S;
use Zeapps\Core\Translation;

class TranslateConsole
{
    public static function execute($argv = null) {
        $languages = Translation::getInstance()->getLanguage();


        // traduction du core
        self::scanDir(SYSDIR, BASEPATH . "/space/", "CORE", $languages);
        self::scanDir(SYSDIR, SYSDIR . "/config/", "CORE", $languages);
        self::scanDir(SYSDIR, SYSDIR . "/views/", "CORE", $languages);
        self::scanDir(SYSDIR, SYSDIR . "/angularjs/", "CORE", $languages);



        // recherche dans le fichier VIEW (php) les textes qui n'ont pas été traduit
        if (is_dir(MODULEPATH)) {
            if ($folderModule = opendir(MODULEPATH)) {
                while (false !== ($folderItem = readdir($folderModule))) {
                    $dir = MODULEPATH . $folderItem;
                    if (is_dir($dir) && $folderItem != '.'
                        && $folderItem != '..'
                    ) {
                        self::scanDir($dir, $dir . "/views/", $folderItem, $languages);
                        self::scanDir($dir, $dir . "/config/", $folderItem, $languages);
                        self::scanDir($dir, $dir . "/angularjs/", $folderItem, $languages);
                    }
                }
            }
        }
    }

    private static function scanDir($cheminModule, $dossier, $module, &$languages) {
        if (is_dir($dossier)) {
            if ($folderModule = opendir($dossier)) {
                while (false !== ($folderItem = readdir($folderModule))) {
                    $dir = $dossier . $folderItem . "/";
                    if (is_dir($dir) && $folderItem != '.'
                        && $folderItem != '..'
                    ) {
                        self::scanDir($cheminModule, $dir, $module, $languages);
                    } elseif ($folderItem != '.' && $folderItem != '..'
                    ) {
                        if (self::endsWith($dossier . $folderItem, '.php') || self::endsWith($dossier . $folderItem, '.js')) {
                            $contenuFichier = file_get_contents($dossier . $folderItem) ;
                            $retour = self::getTagValue($contenuFichier);
                            if (count($retour)) {
                                foreach ($retour as $toTranslate) {
                                    $cleLangue = array_keys($languages);
                                    foreach ($cleLangue as $langueIso) {
                                        if (!isset($languages[$langueIso][$toTranslate])) {
                                            echo $module . " : " . $toTranslate . " (" . $langueIso . ")" . "\n";

                                            $changementLangue = false;

                                            // recherche le fichier
                                            $cheminFichierLangue = $cheminModule . "/lang/" . $langueIso . ".php";
                                            if (is_file($cheminFichierLangue)) {
                                                $dataLanguage = require $cheminFichierLangue;
                                                if (!isset($dataLanguage[$toTranslate])) {
                                                    $dataLanguage[$toTranslate] = $toTranslate;
                                                    $changementLangue = true;
                                                }
                                            } else {
                                                $dataLanguage = [];
                                                $dataLanguage[$toTranslate] = $toTranslate;
                                                $changementLangue = true;
                                            }

                                            if ($changementLangue) {
                                                // construction du contenu du fichier
                                                $contenuFichierTranslate = "<?php\n";
                                                $contenuFichierTranslate .= "return [\n";
                                                foreach ($dataLanguage as $keyLangue => $valueLangue) {
                                                    $contenuFichierTranslate .= "    \"" . str_replace("\"", "\\\"", $keyLangue) . "\" => \"" . str_replace("\"", "\\\"", $valueLangue) . "\",\n";
                                                }
                                                $contenuFichierTranslate .= "];";

                                                // ecriture du fichier de langue
                                                if (!is_dir($cheminModule . "/lang/")) {
                                                    mkdir($cheminModule . "/lang/");
                                                }
                                                file_put_contents($cheminFichierLangue, $contenuFichierTranslate);
                                            }

                                            $languages[$langueIso][$toTranslate] = $toTranslate ;
                                        }
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