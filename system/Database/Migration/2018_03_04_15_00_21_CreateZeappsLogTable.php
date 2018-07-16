<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsLogTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_log', function (Blueprint $table) {
            $table->increments('id');
           $table->tinyInteger('severity', false, true)->default(0);
           $table->integer('error_code', false, true)->default(0);
           $table->text('message')->default("");
           $table->string('object_type', 32)->default("");
           $table->integer('object_id', false, true)->default(0);
           $table->integer('id_employee', false, true)->default(0);

           $table->timestamps();
           $table->softDeletes();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_log');
    }
}
