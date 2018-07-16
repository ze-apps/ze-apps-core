<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsNotificationsTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->string('module', 255);
            $table->string('color', 32);
            $table->string('status', 255);
            $table->string('message', 255);
            $table->tinyInteger('seen');
            $table->tinyInteger('read_state');
            $table->string('link', 255);

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_notifications');
    }
}
