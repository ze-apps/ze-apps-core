<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateObjectHistoriesTable
{
    public function up()
    {
        Capsule::schema()->create('zeapps_object_histories', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('id_user');
            $table->string('user_name');
            $table->string('table');
            $table->string('id_table');
            $table->string('action');
            $table->longText('json_diff');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_object_histories');
    }
}
