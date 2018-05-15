<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsTokenTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_token', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->string('token', 64);
            $table->timestamp('date_expire');
            $table->timestamps();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_token');
    }
}
