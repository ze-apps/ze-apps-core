<?php
use Zeapps\Core\Routeur ;


Routeur::get('/zeapps/notification/getAll', 'Zeapps\\Controllers\\Notification@getAll');
Routeur::get('/zeapps/notification/getAllUnread', 'Zeapps\\Controllers\\Notification@getAllUnread');
Routeur::get('/zeapps/notification/seenNotification', 'Zeapps\\Controllers\\Notification@seenNotification');
Routeur::get('/zeapps/notification/readNotification', 'Zeapps\\Controllers\\Notification@readNotification');
Routeur::get('/zeapps/notification/readAllNotificationFrom', 'Zeapps\\Controllers\\Notification@readAllNotificationFrom');


