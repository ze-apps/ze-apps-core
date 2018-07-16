<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;
use Zeapps\Models\User;

class CreateZeappsUsersTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email', 255);
            $table->string('password', 64);
            $table->text('rights');
            $table->string('lang', 6);
            $table->decimal('hourly_rate', 8, 2);

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_users');
    }
}
