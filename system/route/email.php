<?php
use Zeapps\Core\Routeur ;



Routeur::get('/zeapps/email/list_partial', 'Zeapps\\Controllers\\Email@list_partial');
Routeur::get('/zeapps/email/filtre/{module}/{id}', 'Zeapps\\Controllers\\Email@filtre');