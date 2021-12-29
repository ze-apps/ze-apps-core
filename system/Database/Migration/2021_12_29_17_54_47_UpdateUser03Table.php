<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class UpdateUser03Table
{
    public function up()
    {
        Capsule::schema()->table('zeapps_email', function (Blueprint $table) {
            $table->string('subject', 255)->change();
        });
    }

    public function down()
    {
    }
}
