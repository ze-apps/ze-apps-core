<?php

use Zeapps\Core\Session;
use Zeapps\Models\User;

if (! function_exists('__t')) {
    function __t($textSrc, $language = null)
    {
        return Zeapps\Core\Translation::translate($textSrc, $language);
    }
}