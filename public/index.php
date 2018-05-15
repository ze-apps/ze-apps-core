<?php
require_once '../vendor/autoload.php';

use Zeapps\Core\Routeur;
use Zeapps\Core\Session;
use Zeapps\Core\Response;
use Zeapps\Core\Translation;

use Config\Database;
use Zeapps\Core\Application;
use Zeapps\Core\Migration;

Session::start();




// initialize application
Application::init();



// load helpers
require_once SYSDIR . 'helpers/http.php';
require_once SYSDIR . 'helpers/utilities.php';


// create directories
Application::createDirectories();







// charge les routes
require_once SYSDIR . 'route/web.php';



// open connection to database
if (is_file(BASEPATH . "config/Database.php")) {
    Database::getConnection();

    // check if migration must lauch
    Migration::chechNewFile();

} else {
    if ($_SERVER['REQUEST_URI'] != Routeur::getRouteByName('zeapps-installer')) {
        redirect('zeapps-installer')->sendResponse();
        exit();
    }
}



if (is_dir(MODULEPATH)) {
    if ($folderModule = opendir(MODULEPATH)) {
        while (false !== ($folderItem = readdir($folderModule))) {
            $dir = MODULEPATH . $folderItem;
            if (is_dir($dir) && $folderItem != '.'
                && $folderItem != '..'
            ) {
                $routeFile = $dir . "/route/web.php" ;
                if (is_file($routeFile)) {
                    require_once $routeFile;
                }
            }
        }
    }
}


function __($key) {
    return Translation::translate($key);
}

Routeur::loadCtrl();