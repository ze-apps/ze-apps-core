<?php

namespace Zeapps\Core;

use Zeapps\Models\Migration as MigrationModel ;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class Migration
{
    public static function chechNewFile() {

        self::checkTableMigrationExists();

        $nbUpdate = 0 ;

        // get max Batch Number
        $idBatch = 1 ;
        $maxBatchRS = MigrationModel::orderBy("batch", "DESC")->get()->first() ;
        if ($maxBatchRS) {
            $idBatch = $maxBatchRS->batch + 1 ;
        }


        // search Migration Files on System
        $folderToCheck = BASEPATH . "system/Database/Migration/" ;
        $nbUpdate += self::checkFolder($folderToCheck, "zeapps", $idBatch);



        // migrate Database from modules
        if (is_dir(MODULEPATH)) {
            if ($folderModule = opendir(MODULEPATH)) {
                while (false !== ($folderModuleName = readdir($folderModule))) {
                    $dir = MODULEPATH . $folderModuleName;
                    if (is_dir($dir) && $folderModuleName != '.'
                        && $folderModuleName != '..'
                    ) {
                        $folderToCheck = $dir . "/Database/Migration/" ;
                        $nbUpdate += self::checkFolder($folderToCheck, $folderModuleName, $idBatch);
                    }
                }
            }
        }

        if ($nbUpdate == 0) {
            if (defined('STDIN')) {
                echo "\033[1;31m " . "Nothing to migrate\033[0m\n";
            }
        }
    }

    public static function rollback() {
        $migrations = MigrationModel::orderBy("batch", "DESC")->orderBy("id", "DESC")->get() ;

        foreach ($migrations as $migration) {
            list($folderModuleName, $folderItem) = explode("/", $migration->migration) ;

            $migrationClassName = self::getMigrationClassName($folderItem);

            $fileMigration = "" ;
            if ($folderModuleName == 'zeapps') {
                $fileMigration = BASEPATH  . "system/Database/Migration/" . $folderItem ;
            } else {
                $fileMigration = MODULEPATH . $folderModuleName . "/Database/Migration/" . $folderItem ;
            }


            if ($fileMigration != "" && is_file($fileMigration)) {
                // load php file
                require_once $fileMigration;

                // execute php file
                $objMigration = new $migrationClassName;
                if (method_exists($objMigration, 'down')) {
                    $objMigration->down();
                }
            }

            if (defined('STDIN')) {
                echo "\033[1;32m " . "Rollback : " . $migration->migration . "\033[0m\n" ;
            }


            MigrationModel::destroy($migration->id);
        }
    }


    private static function checkTableMigrationExists() {
        if(!Capsule::schema()->hasTable('zeapps_migration')) {
            Capsule::schema()->create('zeapps_migration', function (Blueprint $table) {
                $table->increments('id');
                $table->string('migration');
                $table->integer('batch');
                $table->timestamps();
            });
        }
    }

    private static function checkFolder($folderToCheck, $folderModuleName, $idBatch) {
        $nbUpdate = 0 ;
        if (is_dir($folderToCheck)) {
            if ($folderMigration = opendir($folderToCheck)) {
                while (false !== ($folderItem = readdir($folderMigration))) {
                    $fileMigration = $folderToCheck . $folderItem;
                    if (self::endsWith($fileMigration, '.php')) {

                        if (!MigrationModel::where("migration", $folderModuleName . "/" . $folderItem)->get()->first()) {
                            $migrationClassName = self::getMigrationClassName($folderItem);

                            // load php file
                            require_once $fileMigration;

                            // execute php file
                            $objMigration = new $migrationClassName;
                            $objMigration->up();

                            $migrationObj = new MigrationModel;
                            $migrationObj->migration = $folderModuleName . "/" . $folderItem;
                            $migrationObj->batch = $idBatch;
                            $migrationObj->save();

                            $nbUpdate++;


                            if (defined('STDIN')) {
                                echo "\033[1;32m " . "Migrate : " . $folderModuleName . "/" . $folderItem . "\033[0m\n" ;
                            }
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