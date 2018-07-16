<?php
use Zeapps\Core\Routeur ;



Routeur::match(['get','post'], '/installer', 'Zeapps\\Controllers\\Installer@index')->name('zeapps-installer');


Routeur::match(['get','post'], '/', 'Zeapps\\Controllers\\Auth@index')->name('home');
Routeur::get('/logout', 'Zeapps\\Controllers\\Auth@logout')->name('logout');

Routeur::get('/application', 'Zeapps\\Controllers\\App@index')->name('application');


// route pour générer les schema
Routeur::get('/schema', 'Zeapps\\Controllers\\Schema@index');
Routeur::get('/migrate', 'Zeapps\\Controllers\\Schema@migrate');



// Route pour angularJS
Routeur::get('/ng/{url}', 'Zeapps\\Controllers\\App@index');
Routeur::get('/zeapps/app/home', 'Zeapps\\Controllers\\App@home');
Routeur::get('/zeapps/app/get_context', 'Zeapps\\Controllers\\App@get_context');
Routeur::get('/zeapps/notification/getAll', 'Zeapps\\Controllers\\Notification@getAll');
Routeur::get('/zeapps/notification/getAllUnread', 'Zeapps\\Controllers\\Notification@getAllUnread');
Routeur::get('/zeapps/notification/seenNotification', 'Zeapps\\Controllers\\Notification@seenNotification');
Routeur::get('/zeapps/notification/readNotification', 'Zeapps\\Controllers\\Notification@readNotification');
Routeur::get('/zeapps/notification/readAllNotificationFrom', 'Zeapps\\Controllers\\Notification@readAllNotificationFrom');


Routeur::get('/zeapps/directives/zefilter', 'Zeapps\\Controllers\\View@directive_zefilter');




// TODO : c'est à supprimer, cela servait pour les tests
Routeur::get('/test/{idProduit}-{nomProduit}', 'Zeapps\\Controllers\\Auth@index')->name('produit');
Routeur::get('/sales/{idCategorie}/{idProduit}-{nomCategorie}', 'Zeapps\\Controllers\\Auth@test')->name('compte-client');