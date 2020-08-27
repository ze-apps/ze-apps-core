<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;
use Zeapps\Core\Cache;

use Zeapps\Models\Token ;
use Zeapps\Models\User ;
use Zeapps\Models\Groups;
use Zeapps\Models\UserGroups;
use Zeapps\Models\Module ;
use Zeapps\Models\Internationalization;
use Zeapps\Models\Hook;
use Zeapps\Models\Config;

class App extends Controller
{
    private $_modules = [];

    public function index()
    {
        // verifie si la session est active
        if (Session::get('token')) {
            if (User::getUserByToken(Session::get('token'))) {
                $this->update_token();
                return $this->appLoading();
            } else {
                return redirect('home');
            }
        } else {
            return redirect('home');
        }
    }

    public function home(){
        $this->_modules = Module::where('active', '1')->get();

        $this->loadCache();

        $data = $this->getMenus();

        return view("home", $data);
    }

    public function update_token()
    {
        global $globalConfig;

        $sessionLifeTime = 20;
        if (isset($globalConfig["session_lifetime"]) && is_numeric($globalConfig["session_lifetime"])) {
            $sessionLifeTime = $globalConfig["session_lifetime"];
        }

        // verifie si la session est active
        if (Session::get('token')) {
            $tokens = Token::where('token', Session::get('token'))->get();
            if ($tokens && count($tokens) == 1) {
                $tokens[0]->date_expire = date("Y-m-d H:i:s", time() + $sessionLifeTime * 60);
                $tokens[0]->save() ;
            }
        }
    }

    public function get_context(){
        $echo = [];

        // verifie si la session est active
        if (Session::get('token')) {
            $user = User::getUserByToken(Session::get('token'));
            if ($user) {
                $user->password = null;

                $user->i18n = [];
                $internaz = Internationalization::where('id_lang', $user->lang) ;

                foreach($internaz as $row){
                    $user->i18n[$row->src] = $row->translation;
                }

                $echo['user'] = $user;
            }
        }

        $hooks = Hook::get();
        if($hooks && count($hooks)) {
            $echo['hooks'] = $hooks;
        } else {
            $echo['hooks'] = [];
        }


        if($debug = Config::find('zeapps_debug')){
            $echo['debug'] = !!intval($debug->value);
        } else{
            $echo['debug'] = false;
        }

        echo json_encode($echo);
    }

    private function appLoading()
    {
        // recupère le token de l'utiliseteur
        // rights



        $this->_modules = Module::where('active', '1')->get();

        $this->loadCache();

        $data = $this->getMenus();

        $data["numero_serie"] = date("Ymdhis");

        return view("app", $data);
    }

    private function loadCache()
    {
        Cache::generateCache() ;

        return true;
    }

    private function getMenus()
    {
        $data = array();

        $space = $this->loadSpaces();

        $menus = $this->loadMenus();

        $data["menuEssential"] = $this->createEssentialMenu($menus['menuEssential']);

        $data["menuLeft"] = $this->createLeftMenu($space, $menus["menuLeft"]);

        $ret = $this->createHeaderMenu($space, $menus["menuHeader"]);

        $data['menuTopCol1'] = $ret['menuTopCol1'];
        $data['menuTopCol2'] = $ret['menuTopCol2'];

        $rights = [];

        if($user = User::getUserByToken(Session::get('token'))) {
            $userRights = json_decode($user->rights, true);
            foreach ($userRights as $rightKey =>$rightValue) {
                if ($rightValue == 1) {
                    $rights[] = $rightKey;
                }
            }
        }

        foreach ($data['menuEssential'] as $key => $menuItem) {
            if(isset($menuItem['access'])){
                if(array_search($menuItem['access'], $rights) === false){
                    unset($data['menuEssential'][$key]);
                }
            }
        }

        foreach($data['menuLeft'] as &$menuSpace){
            foreach ($menuSpace["item"] as $key => $menuItem) {
                if(isset($menuItem['access'])){
                    if(array_search($menuItem['access'], $rights) === false){
                        unset($menuSpace["item"][$key]);
                    }
                }
            }
        }

        foreach($data['menuTopCol1'] as &$menuSpace){
            foreach ($menuSpace["item"] as $key => $menuItem) {
                if(isset($menuItem['access'])){
                    if(array_search($menuItem['access'], $rights) === false){
                        unset($menuSpace["item"][$key]);
                    }
                }
            }
        }


        foreach($data['menuTopCol2'] as &$menuSpace){
            foreach ($menuSpace["item"] as $key => $menuItem) {
                if(isset($menuItem['access'])){
                    if(array_search($menuItem['access'], $rights) === false){
                        unset($menuSpace["item"][$key]);
                    }
                }
            }
        }


        $data["form"] = true;

        return $data;
    }





    private function loadSpaces()
    {
        /********** charge tous les espaces **********/
        $space = array();
        $folderSpace = BASEPATH . "space/";
        // charge tous les fichiers de conf des menus
        if ($folder = opendir($folderSpace)) {
            while (false !== ($folderItem = readdir($folder))) {
                $fileSpace = $folderSpace . $folderItem;
                if (is_file($fileSpace) && $folderItem != '.' && $folderItem != '..'
                    && $this->endsWith(strtolower($fileSpace), ".php")
                ) {
                    require_once $fileSpace;
                }
            }
        }
        /********** END : charge tous les espaces **********/

        return $space;
    }

    private function loadMenus()
    {
        /************ charge tous les menus de config pour les menus ***********/
        $menuLeft = array();
        $menuHeader = array();
        $menuEssential = array();

        if ($this->_modules && count($this->_modules)) {
            // charge tous les fichiers de conf des menus
            for ($i = 0; $i < sizeof($this->_modules); $i++) {
                $folderModule = MODULEPATH . $this->_modules[$i]->module_id;

                if (is_file($folderModule . '/config/menu.php')) {
                    require_once $folderModule . '/config/menu.php';
                }
            }
        }

        // charge tous les fichiers de conf des menus
        if (is_file(BASEPATH . 'system/config/menu.php')) {
            require_once BASEPATH . 'system/config/menu.php';
        }
        /************ END : charge tous les menus de config pour les menus ***********/

        return array(
            "menuLeft" => $menuLeft,
            "menuHeader" => $menuHeader,
            "menuEssential" => $menuEssential
        );
    }

    private function createEssentialMenu($menuEssential = array())
    {

        /*************** creation du menu essential *************/
        // charges les différents menus
        $data = array();

        // calcul le numero ordre le plus élevé
        $maxOrder = -1;
        foreach ($menuEssential as $menuItem) {
            if (isset($menuItem["order"])) {
                if ($menuItem["order"] > $maxOrder) {
                    $maxOrder = $menuItem["order"];
                }
            }
        }

        if ($maxOrder >= 0) {
            for ($iElementMenu = 0; $iElementMenu <= $maxOrder; $iElementMenu++) {
                foreach ($menuEssential as $menuItem) {
                    if (isset($menuItem["order"])) {
                        if ($menuItem["order"] == $iElementMenu) {
                            $data[] = $menuItem;
                        }
                    }
                }
            }
        }
        /*************** END : creation du menu gauche *************/

        return $data;
    }

    private function createLeftMenu($space = array(), $menuLeft = array())
    {
        /*************** creation du menu gauche *************/
        // charges les différents menus
        $data = array();
        if (isset($space)) {
            foreach ($space as $spaceItem) {
                $dataMenu = array();
                $dataMenu["info"] = $spaceItem;
                $dataMenu["item"] = array();

                // calcul le numero ordre le plus élevé
                $maxOrder = -1;
                foreach ($menuLeft as $menuLeftItem) {
                    if (isset($menuLeftItem["space"]) && isset($menuLeftItem["order"])) {
                        if ($menuLeftItem["space"] == $spaceItem["id"] && $menuLeftItem["order"] > $maxOrder) {
                            $maxOrder = $menuLeftItem["order"];
                        }
                    }
                }

                if ($maxOrder >= 0) {
                    for ($i = 0; $i <= $maxOrder; $i++) {
                        foreach ($menuLeft as $menuLeftItem) {
                            if (isset($menuLeftItem["space"]) && isset($menuLeftItem["order"])) {
                                if ($menuLeftItem["space"] == $spaceItem["id"] && $menuLeftItem["order"] == $i) {
                                    $dataMenu["item"][] = $menuLeftItem;
                                }
                            }
                        }
                    }
                }

                $data[] = $dataMenu;
            }
        }
        /*************** END : creation du menu gauche *************/

        return $data;
    }

    private function createHeaderMenu($space = array(), $menuHeader = array())
    {
        /*************** creation du menu Header *************/

        $data = array();

        $data["menuTopCol1"] = array();
        $data["menuTopCol2"] = array();


        for ($col = 1; $col <= 2; $col++) {

            // calcul le numero ordre le plus élevé
            $maxOrderCol = -1;
            if (isset($space)) {
                foreach ($space as $spaceItem) {
                    if (isset($spaceItem["menu-header"]["col"]) && isset($spaceItem["menu-header"]["order"])) {
                        if ($spaceItem["menu-header"]["col"] == $col
                            && $spaceItem["menu-header"]["order"] > $maxOrderCol
                        ) {
                            $maxOrderCol = $spaceItem["menu-header"]["order"];
                        }
                    }
                }
            }

            if ($maxOrderCol >= 0) {
                for ($iOrderSpace = 0; $iOrderSpace <= $maxOrderCol; $iOrderSpace++) {
                    foreach ($space as $spaceItem) {
                        if (isset($spaceItem["menu-header"]["col"]) && isset($spaceItem["menu-header"]["order"])) {
                            if ($iOrderSpace == $spaceItem["menu-header"]["order"]
                                && $spaceItem["menu-header"]["col"] == $col
                            ) {


                                $dataMenu = array();
                                $dataMenu["info"] = $spaceItem;
                                $dataMenu["item"] = array();

                                // calcul le numero ordre le plus élevé
                                $maxOrder = -1;
                                foreach ($menuHeader as $menuHeaderItem) {
                                    if (isset($menuHeaderItem["space"]) && isset($menuHeaderItem["order"])) {
                                        if ($menuHeaderItem["space"] == $spaceItem["id"]
                                            && $menuHeaderItem["order"] > $maxOrder
                                        ) {
                                            $maxOrder = $menuHeaderItem["order"];
                                        }
                                    }
                                }

                                if ($maxOrder >= 0) {
                                    for ($i = 0; $i <= $maxOrder; $i++) {
                                        foreach ($menuHeader as $menuHeaderItem) {
                                            if (isset($menuHeaderItem["space"]) && isset($menuHeaderItem["order"])) {
                                                if ($menuHeaderItem["space"] == $spaceItem["id"]
                                                    && $menuHeaderItem["order"] == $i
                                                ) {
                                                    $dataMenu["item"][] = $menuHeaderItem;
                                                }
                                            }
                                        }
                                    }
                                }

                                if (count($dataMenu["item"]) > 0) {
                                    if ($col == 1) {
                                        $data["menuTopCol1"][] = $dataMenu;
                                    } elseif ($col == 2) {
                                        $data["menuTopCol2"][] = $dataMenu;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        /*************** END : creation du menu Header *************/

        return $data;
    }

    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}