<?php
use Zeapps\Core\Routeur ;



Routeur::get('/storage/{chemin}', 'Zeapps\\Controllers\\Storage@index');
Routeur::get('/download-storage/{chemin}', 'Zeapps\\Controllers\\Storage@forcedownload');
