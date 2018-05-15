<?php

namespace Zeapps\Console;

use Zeapps\Core\Application;
use Zeapps\Core\Seed;

class SeedConsole
{
    public static function execute() {
        // check if migration must lauch
        Seed::chechNewFile();
    }

    public static function rollback()
    {
        Seed::rollback();
    }
}