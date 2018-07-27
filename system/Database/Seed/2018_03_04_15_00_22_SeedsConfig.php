<?php

use Illuminate\Database\Capsule\Manager as Capsule;

use Zeapps\Models\Config;

class SeedsConfig
{
    public function run()
    {
        // import de compagnies
        Capsule::table('com_zeapps_contact_companies')->truncate();
        $configs = json_decode(file_get_contents(dirname(__FILE__) . "/zeapps_configs.json"));
        foreach ($configs as $config_json) {
            $config = new Config();

            foreach ($config_json as $key => $value) {
                $config->$key = $value ;
            }

            $config->save();
        }
    }
}
