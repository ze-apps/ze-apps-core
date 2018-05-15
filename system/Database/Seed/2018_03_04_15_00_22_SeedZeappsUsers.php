<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Zeapps\Models\User;

class SeedZeappsUsers
{
    public function run()
    {
        Capsule::table('zeapps_users')->insert([
            'firstname' => "John",
            'lastname' => "Doe",
            'email' => 'john.doe@gmail.com',
            'lang' => 'en',
            'password' => hash(User::getTypeHash(), 'password'),
        ]);
    }
}
