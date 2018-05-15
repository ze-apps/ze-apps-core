{!! "<" . "?" . "php" !!}

namespace Config;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database {
    private static $db = array('default' => array(
        'dsn'	=> '',
        'hostname' => '{!! $hostname !!}',
        'username' => '{!! $username !!}',
        'password' => '{!! $password !!}',
        'database' => '{!! $database !!}',
        'dbdriver' => 'mysql',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => (ENVIRONMENT !== 'production'),
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
    )
    );


    public static function getConnection() {
        /******** init database for eloquent **********/
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => Database::$db["default"]["dbdriver"],
            'host'      => Database::$db["default"]["hostname"],
            'database'  => Database::$db["default"]["database"],
            'username'  => Database::$db["default"]["username"],
            'password'  => Database::$db["default"]["password"],
            'charset'   => Database::$db["default"]["char_set"],
            'collation' => Database::$db["default"]["dbcollat"],
            'prefix'    => Database::$db["default"]["dbprefix"],
        ]);


        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();
        /******** END : init database for eloquent **********/
    }
}