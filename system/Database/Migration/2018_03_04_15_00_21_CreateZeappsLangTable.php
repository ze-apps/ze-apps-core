<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsLangTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_lang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 32);
            $table->boolean('active');
            $table->string('iso_code', 2);
            $table->string('language_code', 5);
            $table->string('date_format_lite', 32);
            $table->string('date_format_full', 32);
            $table->tinyInteger('is_rtl');
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_lang');
    }
}
