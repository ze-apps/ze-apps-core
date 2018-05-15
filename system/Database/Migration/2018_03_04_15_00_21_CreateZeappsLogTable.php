<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsLogTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_log', function (Blueprint $table) {
            $table->increments('id_log');
            $table->tinyInteger('severity');
            $table->integer('error_code');
            $table->text('message');
            $table->string('object_type', 32);
            $table->integer('object_id');
            $table->integer('id_employee');
            $table->dateTime('date_add');
            $table->dateTime('date_upd');
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_log');
    }
}
