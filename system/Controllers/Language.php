<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;

use Zeapps\Models\Language as LanguageModel;

class Language extends Controller
{
    public function all()
    {
        echo json_encode(LanguageModel::all());
    }
}