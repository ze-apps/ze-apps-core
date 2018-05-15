<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsGroupsTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label', 255);
            $table->text('rights');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_groups');
    }
}
