<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class UpdateUser02Table
{
    public function up()
    {
        Capsule::schema()->table('zeapps_users', function (Blueprint $table) {
            $table->text('signature')->after('phone');
        });
    }

    public function down()
    {
    }
}
