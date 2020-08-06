<?php

namespace Zeapps\Core;

use Zeapps\Core\Storage;


class Log
{
    private $time_start ;
    private $log = "";

    public function start() {
        $this->time_start = microtime(true);
    }

    public function event($info) {
        $time_end = microtime(true);

        //dividing with 60 will give the execution time in minutes otherwise seconds
        $execution_time = $time_end - $this->time_start;

        if ($this->log != "") {
            $this->log .= "\n" ;
        }
        $this->log .= number_format($execution_time, 2) . " : " . $info ;
    }

    public function write() {
        Storage::saveContent($this->log, "debug_" . date("Y-m-d-H-i-s") . "_" . uniqid() . ".txt", "", true, false);
    }
}