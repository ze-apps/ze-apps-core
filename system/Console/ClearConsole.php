<?php

namespace Zeapps\Console;

use Zeapps\Core\Application;
use Zeapps\Core\Migration;
use Zeapps\Core\Cache;

class ClearConsole
{
    public static function cache($argv = null) {
        // check if migration must lauch
        Cache::generateCache() ;
        echo "\033[1;32m " . "Cache clear\033[0m\n";
    }
}