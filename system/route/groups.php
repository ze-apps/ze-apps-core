<?php
use Zeapps\Core\Routeur ;


// pour les groupes
Routeur::get('/zeapps/group/modal', 'Zeapps\\Controllers\\Group@modal_group');
Routeur::get('/zeapps/group/view', 'Zeapps\\Controllers\\Group@view');
Routeur::get('/zeapps/group/form', 'Zeapps\\Controllers\\Group@form');
Routeur::get('/zeapps/group/get/{id}', 'Zeapps\\Controllers\\Group@get');
Routeur::get('/zeapps/group/all', 'Zeapps\\Controllers\\Group@all');
Routeur::post('/zeapps/group/save', 'Zeapps\\Controllers\\Group@save');
Routeur::post('/zeapps/group/delete/{id}', 'Zeapps\\Controllers\\Group@delete');

