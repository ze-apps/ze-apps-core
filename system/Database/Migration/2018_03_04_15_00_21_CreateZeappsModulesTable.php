<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsModulesTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('module_id', 255);
            $table->string('label', 255);
            $table->boolean('active');
            $table->string('version', 8);
            $table->integer('last_sql');
            $table->text('dependencies');
            $table->text('missing_dependencies');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_modules');
    }
}
