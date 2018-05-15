<?php

namespace Zeapps\Core;

interface iResponse {
    public function sendResponse($codeHTTP = 200);
}