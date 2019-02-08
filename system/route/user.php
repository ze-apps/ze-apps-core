<?php
use Zeapps\Core\Routeur ;


// pour les users
Routeur::get('/zeapps/user/modal_user', 'Zeapps\\Controllers\\User@modal_user');
Routeur::get('/zeapps/user/view', 'Zeapps\\Controllers\\User@view');
Routeur::get('/zeapps/user/form', 'Zeapps\\Controllers\\User@form');
Routeur::get('/zeapps/user/get/{id}', 'Zeapps\\Controllers\\User@get');
Routeur::get('/zeapps/user/get_context/', 'Zeapps\\Controllers\\User@get_context');
Routeur::get('/zeapps/user/all', 'Zeapps\\Controllers\\User@all');
Routeur::post('/zeapps/user/modal/{limit}/{offset}', 'Zeapps\\Controllers\\User@modal');
Routeur::post('/zeapps/user/save', 'Zeapps\\Controllers\\User@save');
Routeur::post('/zeapps/user/delete/{id}', 'Zeapps\\Controllers\\User@delete');
Routeur::get('/zeapps/user/getCurrentUser', 'Zeapps\\Controllers\\User@getCurrentUser');

