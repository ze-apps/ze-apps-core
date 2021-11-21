<?php
namespace Zeapps\Core;

use Illuminate\Database\Eloquent\Model ;
use Zeapps\Models\Module ;

class ModelRequest
{
    public static function getRequestContent() {
        $tabModel = array() ;


        $modules = Module::getActiveModule();

        for ($i = 0; $i < sizeof($modules); $i++) {
            $folderModule = MODULEPATH . $modules[$i]->module_id . "/Models/";
            if (is_dir($folderModule)) {
                // charge tous les fichiers de conf des menus
                if ($folder = opendir($folderModule)) {
                    while (false !== ($folderItem = readdir($folder))) {
                        $fileSpace = $folderModule . $folderItem;
                        if (is_file($fileSpace) && $folderItem != '.' && $folderItem != '..'
                            && self::endsWith(strtolower($fileSpace), ".php")
                        ) {
                            $nomClass = substr($folderItem, 0, strlen($folderItem) - 4) ;

                            $classModel = "\\App\\" . $modules[$i]->module_id . "\\Models\\" . $nomClass ;
                            $testModel = new $classModel() ;
                            if ($testModel instanceof Model) {

                                if (method_exists ( $testModel, "getModelExport" )) {
                                    $modelExportType = $testModel->getModelExport() ;

                                    if (!isset($tabModel[$modules[$i]->module_id])) {
                                        $tabModel[$modules[$i]->module_id] = array();
                                        $tabModel[$modules[$i]->module_id]["tables"] = array() ;
                                        $tabModel[$modules[$i]->module_id]["module_name"] = $modules[$i]->label ;
                                    }

                                    $tabModel[$modules[$i]->module_id]["tables"][] = $modelExportType ;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $tabModel ;
    }



    private static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}