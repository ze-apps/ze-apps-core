<?php

namespace Zeapps\Core;

use Zeapps\Core\iResponse;

class Response
{
    public static function send($data, $codeHTTP = 200) {
        if ($data instanceof iResponse) {
            $data->sendResponse($codeHTTP);
        }
    }
}