<?php
use Zeapps\Core\Routeur ;



Routeur::get('/zeapps/modules', 'Zeapps\\Controllers\\Modules@index');

Routeur::get('/zeapps/modules/getAll', 'Zeapps\\Controllers\\Modules@getAll');

