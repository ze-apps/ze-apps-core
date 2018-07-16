<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsConfigsTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('value');

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_configs');
    }
}
