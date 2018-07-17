<?php
use Zeapps\Core\Routeur ;

Routeur::match(['get','post'], '/', 'Zeapps\\Controllers\\Auth@index')->name('home');
Routeur::get('/logout', 'Zeapps\\Controllers\\Auth@logout')->name('logout');
