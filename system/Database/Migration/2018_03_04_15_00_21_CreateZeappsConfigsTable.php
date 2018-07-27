<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsConfigsTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_configs', function (Blueprint $table) {
            $table->string('id');
            $table->text('value');

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_configs');
    }
}
