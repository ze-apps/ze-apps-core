<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsLangTable
{

    public function up()
    {
       Capsule::schema()->create('zeapps_lang', function (Blueprint $table) {
            $table->increments('id');
           $table->string('name', 32)->default("");
           $table->tinyInteger('active', false, true)->default(0);
           $table->string('iso_code', 2)->default("");
           $table->string('language_code', 5)->default("");
           $table->string('date_format_lite', 32)->default("Y-m-d");
           $table->string('date_format_full', 32)->default("Y-m-d H:i:s");
           $table->tinyInteger('is_rtl', false, true)->default(0);
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_lang');
    }
}
