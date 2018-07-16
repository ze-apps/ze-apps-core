<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Illuminate\Database\Capsule\Manager as Capsule;

class Schema extends Controller
{
    public function index(Request $request) {
        $sautLigne = "\n" ;



        $dbName = "zeapps" ;

        $tables = Capsule::select(Capsule::raw('SHOW TABLES FROM ' . $dbName));
        foreach ($tables as $table) {
            $nomChamps = "Tables_in_" . $dbName ;
            //echo $table->$nomChamps . "\n" ;






            $table = $table->$nomChamps ;
            $tableCamelCase = $table ;
            $tableCamelCase = str_replace("_", " ", $tableCamelCase);
            $tableCamelCase = ucwords($tableCamelCase);
            $tableCamelCase = str_replace(" ", "", $tableCamelCase);
            $fields = Capsule::select(Capsule::raw('SHOW COLUMNS FROM ' . $table));

            $contenuPhp = "" ;
            $contenuPhp .= "<?php" . $sautLigne ;
            $contenuPhp .= "" . $sautLigne ;
            $contenuPhp .= "use Illuminate\Database\Schema\Blueprint;" . $sautLigne ;
            $contenuPhp .= "use Illuminate\Database\Migrations\Migration;" . $sautLigne ;
            $contenuPhp .= "use Illuminate\Database\Capsule\Manager as Capsule;" . $sautLigne ;
            $contenuPhp .= "" . $sautLigne ;
            $contenuPhp .= "class Create" . $tableCamelCase . "Table extends Migration" . $sautLigne ;
            $contenuPhp .= "{" . $sautLigne ;
            $contenuPhp .= "" . $sautLigne ;
            $contenuPhp .= "    public function up()" . $sautLigne ;
            $contenuPhp .= "    {" . $sautLigne ;
            $contenuPhp .= '       Capsule::schema()->create(\'' . $table . '\', function (Blueprint $table) {' . $sautLigne ;


            $dateCreate = false ;
            $softdelete = false ;
            foreach ($fields as $field) {
                if ($field->Extra == "auto_increment") {
                    $contenuPhp .= '            $table->increments(\'' . $field->Field . '\');' . $sautLigne ;

                } elseif($field->Field == 'created_at' || $field->Field == 'updated_at') {
                    $dateCreate = true ;
                } elseif($field->Field == 'deleted_at') {
                    $softdelete = true ;

                } elseif (strpos($field->Type, "varchar") === 0) {
                    $length = str_replace("varchar(", "", str_replace(")", "", $field->Type));
                    $contenuPhp .= '            $table->string(\'' . $field->Field . '\', ' . $length . ');' . $sautLigne ;

                } elseif (strpos($field->Type, "char") === 0) {
                    $length = str_replace("char(", "", str_replace(")", "", $field->Type));
                    $contenuPhp .= '            $table->string(\'' . $field->Field . '\', ' . $length . ');' . $sautLigne ;




                } elseif (strpos($field->Type, "text") === 0) {
                    $contenuPhp .= '            $table->text(\'' . $field->Field . '\');' . $sautLigne ;


                } elseif (strpos($field->Type, "float") === 0) {
                    $length = str_replace("float(", "", str_replace(")", "", $field->Type));
                    $length = str_replace(" unsigned", "", $field->Type);
                    $tabLength = explode(",", $length) ;
                    if (count($length) == 2) {
                        $contenuPhp .= '            $table->decimal(\'' . $field->Field . '\', ' . $tabLength[0] . ', ' . $tabLength[1] . ');' . $sautLigne;
                    } else {
                        $contenuPhp .= '            $table->decimal(\'' . $field->Field . '\', 8, 2);' . $sautLigne;
                    }


                } elseif (strpos($field->Type, "enum") === 0) {
                    $values = str_replace("enum(", "[", str_replace(")", "]", $field->Type));

                    $contenuPhp .= '            $table->enum(\'' . $field->Field . '\', ' . $values . ');' . $sautLigne;


                } elseif (strpos($field->Type, "double") === 0) {
                    $contenuPhp .= '            $table->double(\'' . $field->Field . '\');' . $sautLigne ;

                } elseif (strpos($field->Type, "decimal") === 0) {
                    $contenuPhp .= '            $table->decimal(\'' . $field->Field . '\', 9, 2);' . $sautLigne ;


                } elseif (strpos($field->Type, "int") === 0) {
                    $contenuPhp .= '            $table->integer(\'' . $field->Field . '\');' . $sautLigne ;

                } elseif (strpos($field->Type, "tinyint") === 0) {
                    $contenuPhp .= '            $table->tinyInteger(\'' . $field->Field . '\');' . $sautLigne ;

                } elseif (strpos($field->Type, "smallint") === 0) {
                    $contenuPhp .= '            $table->tinyInteger(\'' . $field->Field . '\');' . $sautLigne ;


                } elseif (strpos($field->Type, "longtext") === 0) {
                    $contenuPhp .= '            $table->longtext(\'' . $field->Field . '\');' . $sautLigne ;

                } elseif (strpos($field->Type, "mediumtext") === 0) {
                    $contenuPhp .= '            $table->mediumtext(\'' . $field->Field . '\');' . $sautLigne ;

                } elseif (strpos($field->Type, "bigint") === 0) {
                    $length = str_replace("bigint(", "", str_replace(")", "", $field->Type));
                    if ($length != "") {
                        $contenuPhp .= '            $table->bigInteger(\'' . $field->Field . '\', ' . $length . ');' . $sautLigne;
                    } else {
                        $contenuPhp .= '            $table->bigInteger(\'' . $field->Field . '\');' . $sautLigne;
                    }

                } elseif (strpos($field->Type, "datetime") === 0) {
                    $contenuPhp .= '            $table->dateTime(\'' . $field->Field . '\');' . $sautLigne ;

                } elseif (strpos($field->Type, "date") === 0) {
                    $contenuPhp .= '            $table->date(\'' . $field->Field . '\');' . $sautLigne ;

                } elseif (strpos($field->Type, "timestamp") === 0) {
                    $contenuPhp .= '            $table->timestamp(\'' . $field->Field . '\');' . $sautLigne ;




                } else {
                    echo "INCONNU : " . $sautLigne ;
                    echo "Table : " . $table. $sautLigne ;
                    echo "Field : " . $field->Field . $sautLigne ;
                    echo "Type : " . $field->Type . $sautLigne ;
                    echo "Key : " . $field->Key . $sautLigne ;
                    echo "Default : " . $field->Default . $sautLigne ;
                    echo "Extra : " . $field->Extra . $sautLigne ;
                    echo "******************" . $sautLigne ;
                }

            }


            if ($dateCreate) {
                $contenuPhp .= '            $table->timestamps();' . $sautLigne ;
            }

            if ($softdelete) {
                $contenuPhp .= '            $table->softDeletes();' . $sautLigne ;
            }



            $contenuPhp .= "        });" . $sautLigne ;
            $contenuPhp .= "    }" . $sautLigne ;
            $contenuPhp .= "" . $sautLigne ;
            $contenuPhp .= "" . $sautLigne ;
            $contenuPhp .= "    public function down()" . $sautLigne ;
            $contenuPhp .= "    {" . $sautLigne ;
            $contenuPhp .= "        Capsule::schema()->dropIfExists('" . $table . "');" . $sautLigne ;
            $contenuPhp .= "    }" . $sautLigne ;
            $contenuPhp .= "}" . $sautLigne ;

            echo $contenuPhp ;

            // ecriture du fichier dans le dossier temporaire
            recursive_mkdir(BASEPATH . "tmp/Migration/");
            file_put_contents(BASEPATH . "tmp/Migration/" . date("Y_m_d_H_i_s") . "_Create" . $tableCamelCase . "Table.php", $contenuPhp);
        }







    }


    public function migrate(Request $request) {
        require_once BASEPATH . "system/Migration/2018_03_04_14_20_00_CreateZeappsUsersTable.php";


        $objMigrate = new \CreateZeappsUsersTable() ;
        $objMigrate->up();
    }
}