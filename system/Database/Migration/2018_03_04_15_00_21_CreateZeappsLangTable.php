<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

use Zeapps\Models\Language;

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

            $table->timestamps();
            $table->softDeletes();
        });

        // Création de la langue par defaut
        Capsule::table('zeapps_lang')->truncate();

        $language = new Language();
        $language->id = 1;
        $language->name = "Français";
        $language->active = 1;
        $language->iso_code = "fr";
        $language->language_code = "fr-FR";
        $language->date_format_lite = "d/m/Y";
        $language->date_format_full = "d/m/Y H:i:s";
        $language->is_rtl = 0;
        $language->save();

        $language = new Language();
        $language->id = 2;
        $language->name = "English";
        $language->active = 1;
        $language->iso_code = "en";
        $language->language_code = "en-US";
        $language->date_format_lite = "Y-m-d";
        $language->date_format_full = "Y-m-d H:i:s";
        $language->is_rtl = 0;
        $language->save();
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_lang');
    }
}
