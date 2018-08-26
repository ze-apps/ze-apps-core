<?php

namespace Zeapps\Core;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;
use Zeapps\Core\Migration;

class Application
{
    public static function init()
    {
        define(
            'ENVIRONMENT',
            isset($_SERVER['CI_ENV']) ?
                $_SERVER['CI_ENV'] : 'development'
        );

        switch (ENVIRONMENT) {
            case 'development':
                error_reporting(-1);
                ini_set('display_errors', 1);
                break;

            case 'testing':
            case 'production':
                ini_set('display_errors', 0);
                if (version_compare(PHP_VERSION, '5.3', '>=')) {
                    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
                } else {
                    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
                }
                break;

            default:
                header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
                echo 'The application environment is not set correctly.';
                exit(1); // EXIT_ERROR
        }


        // System Folder
        $systemPath = '../';


        if (($systemRealPath = realpath($systemPath)) !== FALSE) {
            $systemPath = $systemRealPath . DIRECTORY_SEPARATOR;
        } else {
            // Ensure there's a trailing slash
            $systemPath = strtr(
                    rtrim($systemPath, '/\\'),
                    '/\\',
                    DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
                ) . DIRECTORY_SEPARATOR;
        }

        // Is the system path correct?
        if (!is_dir($systemPath)) {
            header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
            echo 'Your system folder path does not appear to be set correctly. 
            Please open the following file and correct this: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
            exit(3); // EXIT_CONFIG
        }

        // The name of THIS file
        define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

        // Path to the system folder
        define('BASEPATH', str_replace('\\', '/', $systemPath));

        // Path to the front controller (this file)
        define('FCPATH', dirname(__FILE__) . '/');

        // Name of the "system folder"
        define('SYSDIR', BASEPATH . 'system/');
        //define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

        define('MODULEPATH', realpath(dirname(__FILE__) . '/../../App/') . '/');

        define('PUBLICPATH', realpath(dirname(__FILE__) . '/../../public/') . '/');
    }

    public static function createDirectories()
    {
        if (!is_dir(BASEPATH . "tmp/")) {
            recursive_mkdir(BASEPATH . "tmp/");
        }

        if (!is_dir(BASEPATH . "App/")) {
            recursive_mkdir(BASEPATH . "App/");
        }

        if (!is_dir(BASEPATH . "cache/")) {
            recursive_mkdir(BASEPATH . "cache/");
        }

        if (!is_dir(BASEPATH . "session/")) {
            recursive_mkdir(BASEPATH . "session/");
        }
    }
}