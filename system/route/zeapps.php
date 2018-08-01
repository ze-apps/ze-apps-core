<?php
use Zeapps\Core\Routeur ;



Routeur::match(['get','post'], '/installer', 'Zeapps\\Controllers\\Installer@index')->name('zeapps-installer');


Routeur::get('/application', 'Zeapps\\Controllers\\App@index')->name('application');


// Migrate for update database
Routeur::get('/migrate', 'Zeapps\\Controllers\\Schema@migrate');



// Route pour angularJS
Routeur::get('/ng/{url}', 'Zeapps\\Controllers\\App@index');
Routeur::get('/zeapps/app/home', 'Zeapps\\Controllers\\App@home');
Routeur::get('/zeapps/app/get_context', 'Zeapps\\Controllers\\App@get_context');
Routeur::get('/zeapps/app/update_token', 'Zeapps\\Controllers\\App@update_token');