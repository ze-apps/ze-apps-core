<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class UpdateUser01Table
{
    public function up()
    {
        Capsule::schema()->table('zeapps_users', function (Blueprint $table) {
            $table->string('phone', 20)->after('password')->default("");
        });
    }

    public function down()
    {
    }
}
