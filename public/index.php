<?php
require_once '../vendor/autoload.php';

use Zeapps\Core\Routeur;
use Zeapps\Core\Session;
use Zeapps\Core\Response;
use Zeapps\Core\Translation;

use Config\Database;
use Zeapps\Core\Application;
use Zeapps\Core\Migration;





// initialize application
Application::init();



// load helpers
require_once SYSDIR . 'helpers/http.php';
require_once SYSDIR . 'helpers/utilities.php';


// create directories
Application::createDirectories();






// start session
Session::start();




// charge les routes
$dossierRoute = SYSDIR . 'route/' ;
if (is_dir($dossierRoute)) {
    if ($folderModule = opendir($dossierRoute)) {
        while (false !== ($folderItem = readdir($folderModule))) {
            if ($folderItem != '.'
                && $folderItem != '..'
                && str_ends_with($folderItem, ".php")
            ) {
                $routeFile = $dossierRoute . $folderItem ;
                if (is_file($routeFile)) {
                    require_once $routeFile;
                }
            }
        }
    }
}



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
                /*$routeFile = $dir . "/route/web.php" ;
                if (is_file($routeFile)) {
                    require_once $routeFile;
                }*/
                $dossierRoute = $dir . '/route/' ;
                if (is_dir($dossierRoute)) {
                    if ($folderModuleRoute = opendir($dossierRoute)) {
                        while (false !== ($folderItemRoute = readdir($folderModuleRoute))) {
                            if ($folderItemRoute != '.'
                                && $folderItemRoute != '..'
                                && str_ends_with($folderItemRoute, ".php")
                            ) {
                                $routeFile = $dossierRoute . $folderItemRoute ;
                                if (is_file($routeFile)) {
                                    require_once $routeFile;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}


function __($key) {
    return Translation::translate($key);
}

Routeur::loadCtrl();