<?php
use Zeapps\Core\Routeur ;



Routeur::get('/zeapps/directives/zefilter', 'Zeapps\\Controllers\\View@directive_zefilter');
Routeur::get('/zeapps/directives/form_modal', 'Zeapps\\Controllers\\View@form_modal');
Routeur::get('/zeapps/directives/zepostits', 'Zeapps\\Controllers\\View@zepostits');
Routeur::get('/zeapps/directives/search_modal', 'Zeapps\\Controllers\\View@search_modal');



