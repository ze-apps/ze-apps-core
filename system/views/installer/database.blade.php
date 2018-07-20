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


        foreach (Database::$db as $key => $value) {
            $capsule->addConnection([
                'driver' => Database::$db[$key]["dbdriver"],
                'host' => Database::$db[$key]["hostname"],
                'database' => Database::$db[$key]["database"],
                'username' => Database::$db[$key]["username"],
                'password' => Database::$db[$key]["password"],
                'charset' => Database::$db[$key]["char_set"],
                'collation' => Database::$db[$key]["dbcollat"],
                'prefix' => Database::$db[$key]["dbprefix"],
            ], $key);
        }

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();
        /******** END : init database for eloquent **********/
    }
}