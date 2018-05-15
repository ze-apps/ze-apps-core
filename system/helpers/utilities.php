<?php


if (! function_exists('str_ends_with')) {
    function str_ends_with($haystack, $needle)
    {
        return strrpos($haystack, $needle) + strlen($needle) === strlen($haystack);
    }
}


if (! function_exists('clearCache')) {
    function clearCache()
    {
        rrmdir(FCPATH . 'assets/cache');
        return true;
    }
}


if (! function_exists('rrmdir')) {
    function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object))
                        rrmdir($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            rmdir($dir);
        }
        return true;
    }
}


if (! function_exists('recursive_mkdir')) {
    function recursive_mkdir($dirName)
    {
        if (!is_dir($dirName)) {
            mkdir($dirName, 0777, true);
        }
    }
}

if (! function_exists('r_mvdir')) {
    function r_mvdir($src, $dst)
    {
        if (is_dir($src)) {
            $dirHandle = opendir($src);
            while ($file = readdir($dirHandle)) {
                if ($file != "." && $file != "..") {
                    if (is_dir($src . "/" . $file)) {
                        if (!is_dir($dst . "/" . $file)) {
                            recursive_mkdir($dst . "/" . $file);
                        }
                        if (!r_mvdir($src . "/" . $file, $dst . "/" . $file)) {
                            return false;
                        }
                    } else {
                        if (!copy($src . "/" . $file, $dst . "/" . $file)) {
                            return false;
                        }
                    }
                }
            }
            closedir($dirHandle);
        } else {
            if (!copy($src, $dst)) {
                return false;
            }
        }
        return true;
    }
}

if (! function_exists('minifyCss')) {
    function minifyCss($css)
    {
        // Remove comments
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);

        // Remove space after colons
        $css = str_replace(array(': ', ' :', ' {', '{ ', ' }', '} '), array(':', ':', '{', '{', '}', '}'), $css);

        // Remove whitespace
        $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);

        return $css;
    }
}

if (! function_exists('minifyJs')) {
    function minifyJs($js)
    {
        global $globalConfig;

        if (isset($globalConfig["minifyjs"]) && $globalConfig["minifyjs"]) {
            // Remove comments
            $js = preg_replace('/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/', '', $js);

            // Remove whitespace
            $js = str_replace(array("\t", "\r\n", "\n", "\r", '  ', '    ', '    '), ' ', $js);

            // Remove space around colons
            $js = str_replace(array(' :', ': ', ":\r", ":\n", ":\r\n"), ':', $js);
            $js = str_replace(array(' ;', '; ', ";\r", ";\n", ";\r\n"), ';', $js);
            $js = str_replace(array(' ,', ', ', ",\r", ",\n", ",\r\n"), ',', $js);
            $js = str_replace(array(' .', '. ', ".\r", ".\n", ".\r\n", "\r.", "\n.", "\r\n."), '.', $js);
            $js = str_replace(array(' {', '{ '), '{', $js);
            $js = str_replace(array(' }', '} ', "}\r", "}\n", "}\r\n"), '}', $js);
            $js = str_replace(array(' (', '( '), '(', $js);
            $js = str_replace(array(' )', ') ', ")\r", ")\n", ")\r\n"), ')', $js);
            $js = str_replace(array(' [', '[ '), '[', $js);
            $js = str_replace(array(' ]', '] ', "]\r", "]\n", "]\r\n"), ']', $js);

            // Remove space around signs
            $js = str_replace(array(' =', '= '), '=', $js);
            $js = str_replace(array(' >', '> '), '>', $js);
            $js = str_replace(array(' <', '< '), '<', $js);
            $js = str_replace(array(' +', '+ ', "+\r", "+\n", "+\r\n"), '+', $js);
            $js = str_replace(array(' -', '- '), '-', $js);
            $js = str_replace(array(' *', '* '), '*', $js);
            $js = str_replace(array(' /', '/ '), '/', $js);
            $js = str_replace(array(' %', '% '), '%', $js);

            // Flaten if-else
            $js = str_replace(array("if\r", "if\n", "if\r\n"), "if ", $js);
            $js = str_replace(array("else\r", "else\n", "else\r\n", "\relse", "\nelse", "\r\nelse"), "else", $js);

            // to avoid bugs
            $js = str_replace("elseif", "else if", $js);

            // Remove spaces around ({[]})
            $js = str_replace(array("(\r", "(\n", "(\r\n"), "(", $js);
            $js = str_replace(array("{\r", "{\n", "{\r\n"), "{", $js);
            $js = str_replace(array("[\r", "[\n", "[\r\n"), "[", $js);
            $js = str_replace(array("\r)", "\n)", "\r\n)"), ")", $js);
            $js = str_replace(array("\r}", "\n}", "\r\n}"), "}", $js);
            $js = str_replace(array("\r]", "\n]", "\r\n]"), "]", $js);

            $js = str_replace(array(), ";", $js);
            $js = str_replace(array(), ",", $js);
        }

        return $js;
    }
}

if (! function_exists('formatNumber')) {
    function formatNumber($num, $size, $padded = false)
    {

        if ($size > strlen($num) && $padded) {
            $padded = str_pad($num, $size, '0', STR_PAD_LEFT);
        } else {
            $padded = substr($num, -$size);
        }

        return $padded;
    }
}