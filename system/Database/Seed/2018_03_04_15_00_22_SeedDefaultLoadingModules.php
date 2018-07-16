<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Zeapps\Models\User;

class SeedDefaultLoadingModules
{
    public function run()
    {
        Capsule::table('zeapps_modules')->truncate();


        Capsule::table('zeapps_modules')->insert([
            'module_id' => "com_zeapps_contact",
            'label' => "com_zeapps_contact",
            'active' => "1",
            'version' => "1.0.0",
            'last_sql' => "0",
            'dependencies' => "",
            'missing_dependencies' => "",
            'created_at'=>'2018-01-01',
            'updated_at'=>'2018-01-01',
        ]);


        Capsule::table('zeapps_modules')->insert([
            'module_id' => "com_zeapps_crm",
            'label' => "com_zeapps_crm",
            'active' => "1",
            'version' => "1.0.0",
            'last_sql' => "0",
            'dependencies' => "",
            'missing_dependencies' => "",
            'created_at'=>'2018-01-01',
            'updated_at'=>'2018-01-01',
        ]);
    }
}
