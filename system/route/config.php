<?php
use Zeapps\Core\Routeur ;



Routeur::get('/zeapps/config', 'Zeapps\\Controllers\\Config@index');


Routeur::get('/zeapps/config/get/{id}', 'Zeapps\\Controllers\\Config@get');
Routeur::get('/zeapps/config/emptyCache', 'Zeapps\\Controllers\\Config@emptyCache');
Routeur::post('/zeapps/config/save', 'Zeapps\\Controllers\\Config@save');