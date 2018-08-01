<?php

namespace Zeapps\Core;

use Zeapps\Models\Migration as MigrationModel ;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class Seed
{
    public static function chechNewFile() {

        $nbUpdate = 0 ;

        // search Migration Files on System
        $folderToCheck = BASEPATH . "system/Database/Seed/" ;
        $nbUpdate += self::checkFolder($folderToCheck, "zeapps");



        // migrate Database from modules
        if (is_dir(MODULEPATH)) {
            if ($folderModule = opendir(MODULEPATH)) {
                while (false !== ($folderModuleName = readdir($folderModule))) {
                    $dir = MODULEPATH . $folderModuleName;
                    if (is_dir($dir) && $folderModuleName != '.'
                        && $folderModuleName != '..'
                    ) {
                        $folderToCheck = $dir . "/Database/Seed/" ;
                        $nbUpdate += self::checkFolder($folderToCheck, $folderModuleName);
                    }
                }
            }
        }

        if ($nbUpdate == 0) {
            if (defined('STDIN')) {
                echo "\033[1;31m " . "Nothing to seeding\033[0m\n";
            }
        }
    }

    private static function checkFolder($folderToCheck, $folderModuleName) {
        $nbUpdate = 0 ;
        if (is_dir($folderToCheck)) {
            if ($folderMigration = opendir($folderToCheck)) {
                while (false !== ($folderItem = readdir($folderMigration))) {
                    $fileMigration = $folderToCheck . $folderItem;
                    if (self::endsWith($fileMigration, '.php')) {

                        $migrationClassName = self::getMigrationClassName($folderItem);

                        echo "\033[1;32m " . "Start : " . $folderModuleName . "/" . $folderItem . "\033[0m\n" ;

                        // load php file
                        require_once $fileMigration;

                        // execute php file
                        $objMigration = new $migrationClassName;
                        $objMigration->run();

                        $nbUpdate++;


                        if (defined('STDIN')) {
                            echo "\033[1;32m " . "Seeding : " . $folderModuleName . "/" . $folderItem . "\033[0m\n" ;
                        }

                    }
                }
            }
        }

        return $nbUpdate ;
    }


    private static function getMigrationClassName($folderItem) {
        $tabFile = explode("_", $folderItem);
        $firstIndexChar = -1;
        for ($i = 0; $i < count($tabFile); $i++) {
            if (!is_numeric($tabFile[$i])) {
                $firstIndexChar = $i;
                break;
            }
        }

        $migrationClassName = "";
        for ($i = $firstIndexChar; $i < count($tabFile); $i++) {
            if ($migrationClassName != "") {
                $migrationClassName .= "_";
            }
            $migrationClassName .= $tabFile[$i];
        }


        $migrationClassName = substr($migrationClassName, 0, strlen($migrationClassName) - 4);

        return $migrationClassName ;
    }


    private static function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }
}