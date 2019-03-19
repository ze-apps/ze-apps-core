function __t($textSrc, $language = null) {
    if (!$language) {
        $language = "fr" ;
    }

    if (arrTranslateJSon[$language] && arrTranslateJSon[$language][$textSrc]) {
        $textSrc = arrTranslateJSon[$language][$textSrc] ;
    }

    return $textSrc;
}