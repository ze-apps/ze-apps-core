<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsTriggersTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_triggers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label', 255);
            $table->string('module', 255);
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_triggers');
    }
}
