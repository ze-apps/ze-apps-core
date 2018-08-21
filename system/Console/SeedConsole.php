<?php

namespace Zeapps\Console;

use Zeapps\Core\Application;
use Zeapps\Core\Seed;

class SeedConsole
{
    public static function execute($argv = null) {
        // check if migration must lauch
        Seed::chechNewFile($argv);
    }
}