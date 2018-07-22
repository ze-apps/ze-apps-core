<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Zeapps\Models\User;

class SeedZeappsUsers
{
    public function run()
    {
        Capsule::table('zeapps_users')->truncate();
        Capsule::table('zeapps_groups')->truncate();
        Capsule::table('zeapps_user_groups')->truncate();




        Capsule::table('zeapps_users')->insert([
            'id'=>1,
            'firstname' => "John",
            'lastname' => "Doe",
            'email' => 'john.doe@gmail.com',
            'lang' => 'en',
            'password' => hash(User::getTypeHash(), 'password'),
            'created_at'=>'2018-01-01',
            'updated_at'=>'2018-01-01',
        ]);



        // creation d'un groupe
        Capsule::table('zeapps_groups')->insert([
            'id'=>1,
            'label' => "Testeur",
            'rights' => json_encode(array(
                "com_zeapps_project_write"=>1,
                "com_zeapps_project_read"=>1,
                "com_zeapps_project_management"=>1,
                "com_zeapps_project_financial"=>1,
                "com_zeapps_contact_read"=>1,
                "com_zeapps_contact_write"=>1,
                "com_zeapps_crm_read"=>1,
                "com_zeapps_crm_write"=>1
            )),
            'created_at'=>'2018-01-01',
            'updated_at'=>'2018-01-01',
        ]);


        // Adhésion au groupe
        Capsule::table('zeapps_user_groups')->insert([
            'id'=>1,
            'id_user'=>1,
            'id_group'=>1,
            'created_at'=>'2018-01-01',
            'updated_at'=>'2018-01-01',
        ]);
    }
}
