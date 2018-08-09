<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsEmailModuleTable
{
    public function up()
    {
        Capsule::schema()->create('zeapps_email_module', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_email')->default(0);
            $table->string('module')->default("");
            $table->string('filtre_module')->default("");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_email_module');
    }
}
