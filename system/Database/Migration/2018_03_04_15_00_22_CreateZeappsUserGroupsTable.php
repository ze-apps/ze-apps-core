<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsUserGroupsTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_user_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->integer('id_group');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_user_groups');
    }
}
