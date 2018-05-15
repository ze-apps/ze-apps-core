<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsHooksTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_hooks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hook', 255);
            $table->string('template', 255);
            $table->string('label', 255);
            $table->tinyInteger('shown');
            $table->integer('sort');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_hooks');
    }
}
