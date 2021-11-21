<?php

namespace Zeapps\Models ;

use Illuminate\Database\Eloquent\Model ;

class Module extends Model {

    protected $table = 'zeapps_modules';

    public static function getActiveModule() {
        $modules_src = Module::where('active', '1')->get();
        $modules = [];

        // récupère la liste des modules déclarés désactivés dans .env
        $disabledModules = env("disabledModules");
        if ($disabledModules) {
            $disabledModules = explode(",", str_replace(" ", "", $disabledModules));
        } else {
            $disabledModules = [];
        }

        foreach($modules_src as $module) {
            if (!in_array($module->label, $disabledModules)) {
                $modules[] = $module ;
            }
        }

        return $modules ;
    }
}