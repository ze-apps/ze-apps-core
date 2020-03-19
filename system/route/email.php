<?php
use Zeapps\Core\Routeur ;



Routeur::get('/zeapps/email/send_email', 'Zeapps\\Controllers\\Email@send_email');
Routeur::post('/zeapps/email/send_email_post', 'Zeapps\\Controllers\\Email@sendEmailPost');

Routeur::get('/zeapps/email/list_partial', 'Zeapps\\Controllers\\Email@list_partial');
Routeur::get('/zeapps/email/filtre/{module}/{id}', 'Zeapps\\Controllers\\Email@filtre');

Routeur::post("/zeapps/email/file/upload", 'Zeapps\\Controllers\\Email@uploadFile');