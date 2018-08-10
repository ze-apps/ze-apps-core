<?php
use Zeapps\Core\Routeur ;



Routeur::get('/zeapps/cron/execute', 'Zeapps\\Controllers\\Cron@execute');