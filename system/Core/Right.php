<?php

namespace Zeapps\Core;

use Zeapps\Models\Module;

class Right
{
    /**
     * @var Singleton
     * @access private
     * @static
     */
    private static $_instance = null;

    private $_rights=null;

    /**
     * Constructeur de la classe
     *
     * @param void
     * @return void
     */
    private function __construct()
    {
    }

    /**
     * Méthode qui crée l'unique instance de la classe
     * si elle n'existe pas encore puis la retourne.
     *
     * @param void
     * @return Singleton
     */
    public static function getInstance() {

        if(is_null(self::$_instance)) {
            self::$_instance = new Right();
        }

        return self::$_instance;
    }

    public function getRight()
    {
        if (!$this->_rights) {
            $modules = Module::where('active', '1')->get();

            /************ charge tous les rights de config ***********/
            $rightZeapps = array();

            if ($modules && count($modules)) {
                // charge tous les fichiers de conf des menus
                for ($i = 0; $i < sizeof($modules); $i++) {
                    $folderModule = MODULEPATH . $modules[$i]->module_id;

                    if (is_file($folderModule . '/config/right.php')) {
                        require_once $folderModule . '/config/right.php';
                    }
                }
            }

            // charge tous les fichiers de conf des menus
            if (is_file(BASEPATH . 'system/config/right.php')) {
                require_once BASEPATH . 'system/config/right.php';
            }
            /************ END : charge tous les rights de config ***********/

            $this->_rights = $rightZeapps ;
        }

        return $this->_rights ;
    }

    public function getRightModule($module) {
        $data = [];
        $rights = $this->getRight() ;
        foreach ($rights as $right) {
            if ($right["module"] == $module) {
                $data[] = $right ;
            }
        }
        return $data ;
    }
}