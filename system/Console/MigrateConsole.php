<?php

namespace Zeapps\Console;

use Zeapps\Core\Application;
use Zeapps\Core\Migration;

class MigrateConsole
{
    public static function execute() {
        // check if migration must lauch
        Migration::chechNewFile();
    }

    public static function rollback()
    {
        Migration::rollback();
    }
}