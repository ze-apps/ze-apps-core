<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsModuleRightsTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_module_rights', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_module');
            $table->text('rights');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_module_rights');
    }
}
