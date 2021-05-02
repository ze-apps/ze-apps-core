<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;

use Zeapps\Core\Translation;

class Translate extends Controller
{
    public function index(Request $request)
    {
        
        $tableauTraduction = [];

        // lecture des traductions dans toutes les langues
        // pour les mettre dans un tableau dont la clé est l'ID de la traduction
        $languages = Translation::getInstance()->getLanguage();
        foreach($languages as $lang=>$traductionLangue) {
            foreach($traductionLangue as $key=>$value) {
                if (!isset($tableauTraduction[$key])) {
                    $tableauTraduction[$key] = [];
                }
                $tableauTraduction[$key][$lang] = $value;
            }
        }

        // 

        return view('translate/index', ["languages"=>$languages, "tableauTraduction"=>$tableauTraduction]);
    }
}