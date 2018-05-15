<?php

namespace Zeapps\Core;

use Zeapps\Core\iResponse;

class Response
{
    public static function send($data) {
        if ($data instanceof iResponse) {
            $data->sendResponse();
        }
    }
}