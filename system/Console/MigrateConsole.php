<?php

namespace Zeapps\Console;

use Zeapps\Core\Application;
use Zeapps\Core\Migration;

class MigrateConsole
{
    public static function execute($argv = null) {
        // check if migration must lauch
        Migration::chechNewFile($argv);
    }

    public static function rollback($argv = null)
    {
        Migration::rollback($argv);
    }
}