<?php

namespace Zeapps\Core;

class Session
{
    public function __construct()
    {
        if (!isset($_SESSION))
            session_start();
    }

    public static function start() {
        if (!isset($_SESSION))
            session_start();
    }

    public static function get($variable, $defaultValue = null)
    {
        if (isset($_SESSION[$variable])) {
            return $_SESSION[$variable];
        } else {
            return $defaultValue;
        }
    }

    public static function set($variable, $value)
    {
        $_SESSION[$variable] = $value;
    }

    public static function clear($variable = null)
    {
        if ($variable) {
            unset($_SESSION[$variable]);
        } else {
            session_unset();
        }
    }
}
