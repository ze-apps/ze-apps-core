<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateZeappsEmailTable
{

    public function up()
    {
        Capsule::schema()->create('zeapps_email', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user_account')->default(0);
            $table->string('name_user_account')->default("");
            $table->timestamp('date_send');
            $table->string('subject', 50);
            $table->longText('content_html');
            $table->longText('content_text');

            $table->text('sender'); // object : example {'name':'Mary from MyShop', 'email':'no-reply@myshop.com'}
            $table->text('to'); // array of objects : example [{'name':'Jimmy', 'email':'jimmy98@example.com'}, {'name':'Joe', 'email':'joe@example.com'}]
            $table->text('bcc'); // array of objects : example [{'name':'Jimmy', 'email':'jimmy98@example.com'}, {'name':'Joe', 'email':'joe@example.com'}]
            $table->text('cc'); // array of objects : example [{'name':'Jimmy', 'email':'jimmy98@example.com'}, {'name':'Joe', 'email':'joe@example.com'}]
            $table->text('attachment'); // array of objects : [{'url':'https://attachment.domain.com/myAttachmentFromUrl.jpg', 'name':'My attachment 1'}, {'content':'base64 exmaple content', 'name':'My attachment 2'}]. Allowed extensions for attachment file: xlsx, xls, ods, docx, docm, doc, csv, pdf, txt, gif, jpg, jpeg, png, tif, tiff, rtf, bmp, cgm, css, shtml, html, htm, zip, xml, ppt, pptx, tar, ez, ics, mobi, msg, pub and eps
            $table->text('tags');
            $table->integer('status');
            $table->string('id_emailer', 500);

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Capsule::schema()->dropIfExists('zeapps_email');
    }
}
