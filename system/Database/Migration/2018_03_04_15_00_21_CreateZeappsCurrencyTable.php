<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsCurrencyTable
{

    public function up()
    {
        Capsule::schema()->create('zeapps_currency', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 32);
            $table->string('iso_code', 3);
            $table->string('iso_code_num', 3);
            $table->string('sign', 8);
            $table->tinyInteger('blank');
            $table->tinyInteger('format');
            $table->tinyInteger('decimals');
            $table->decimal('conversion_rate', 9, 2);
            $table->tinyInteger('deleted');
            $table->tinyInteger('active');

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_currency');
    }
}