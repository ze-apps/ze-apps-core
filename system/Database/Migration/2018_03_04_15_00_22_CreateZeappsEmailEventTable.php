<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsEmailEventTable
{
    public function up()
    {
        Capsule::schema()->create('zeapps_email_event', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_email')->default(0);
            $table->timestamp('date_event')->default("0000-00-00 00:00:00");
            $table->string('event')->default("");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_email_event');
    }
}
