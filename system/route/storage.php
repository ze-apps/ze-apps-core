<?php
use Zeapps\Core\Routeur ;



Routeur::get('/storage/{chemin}', 'Zeapps\\Controllers\\Storage@index');
