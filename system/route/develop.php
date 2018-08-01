<?php
use Zeapps\Core\Routeur ;


// TODO : c'est à supprimer, cela servait pour les tests
//Routeur::get('/test/{idProduit}-{nomProduit}', 'Zeapps\\Controllers\\Auth@index')->name('produit');
//Routeur::get('/sales/{idCategorie}/{idProduit}-{nomCategorie}', 'Zeapps\\Controllers\\Auth@test')->name('compte-client');


// pour générer les seeds pendant la phase de dev
Routeur::get('/generete-seed', 'Zeapps\\Controllers\\GeneratorSeed@generate');


// route pour générer les schema
Routeur::get('/schema', 'Zeapps\\Controllers\\Schema@index');