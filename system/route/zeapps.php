<?php
use Zeapps\Core\Routeur ;



Routeur::match(['get','post'], '/installer', 'Zeapps\\Controllers\\Installer@index')->name('zeapps-installer');


Routeur::get('/application', 'Zeapps\\Controllers\\App@index')->name('application');


// route pour générer les schema
Routeur::get('/schema', 'Zeapps\\Controllers\\Schema@index');
Routeur::get('/migrate', 'Zeapps\\Controllers\\Schema@migrate');



// Route pour angularJS
Routeur::get('/ng/{url}', 'Zeapps\\Controllers\\App@index');
Routeur::get('/zeapps/app/home', 'Zeapps\\Controllers\\App@home');
Routeur::get('/zeapps/app/get_context', 'Zeapps\\Controllers\\App@get_context');