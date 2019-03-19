<?php

namespace Zeapps\Core;

class Storage
{
    private static $folderStorage = "storage/" ;

    public static function getFolderStorage() {
        return self::$folderStorage;
    }

    public static function getIdToFolder($id) {
        $folder = "" ;
        $arrId = str_split($id);
        foreach ($arrId as $numberId) {
            if ($folder != "") {
                $folder .= "/" ;
            }
            $folder .= $numberId ;
        }

        return $folder ;
    }

    public static function getFileBase64($chemin) {
        $chemin = BASEPATH . $chemin ;

        if (is_file($chemin)) {
            $imgbinary = fread(fopen($chemin, "r"), filesize($chemin));
            return base64_encode($imgbinary) ;
        } else {
            return false;
        }
    }


    public static function getFile($chemin, $forcedownload = false) {
        $chemin = BASEPATH . self::$folderStorage . $chemin ;

        if (is_file($chemin)) {

            $ext = substr($chemin, strrpos($chemin, ".")+1) ;
            $fichier = substr($chemin, strrpos($chemin, "/")+1) ;


            if ($forcedownload) {
                header('Content-type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $fichier . '"');
            } else {
                header('Content-type: ' . self::getContentType($ext));
                header('Content-Disposition: ' . self::getContentDisposition($ext) . '; filename="' . $fichier . '"');
            }

            // Le source du PDF original.pdf
            readfile($chemin);
            exit();
        } else {
            return false;
        }
    }

    public static function isFileExists($chemin) {
        $chemin = BASEPATH . $chemin ;

        if (is_file($chemin)) {
            return true;
        } else {
            return false;
        }
    }






    public static function saveBase64($content, $name, $folder = "", $isTemp = false) {
        if ($isTemp) {
            $folder = "tmp/" . $folder ;
        }

        $folder = self::$folderStorage . $folder ;

        if (!self::endsWith($folder, "/")) {
            $folder .= "/" ;
        }

        // stockage dans une arborescence par Date
        $folder .= date("Y/m/d/H/i/s/") ;


        // creation du dossier
        self::mkdir($folder) ;


        // chemin vers le fichier
        $file = $folder . $name ;

        $num_fichier = 0 ;
        while (is_file(BASEPATH . $file)) {
            $num_fichier++;

            if (strrpos($name, ".") !== false) {
                $ext = substr($name, strrpos($name, "."));
                $name_tmp = substr($name, 0, strrpos($name, ".")) . "_" . $num_fichier . $ext;
            } else {
                $name_tmp = $name . "_" . $num_fichier ;
            }

            $file = $folder . $name_tmp ;
        }


        file_put_contents(BASEPATH . $file, base64_decode($content));

        return $file ;
    }



    public static function uploadFile($fieldUpload, $name = "", $folder = "", $isTemp = false) {
        if ($isTemp) {
            $folder = "tmp/" . $folder ;
        }

        $folder = self::$folderStorage . $folder ;

        if (!self::endsWith($folder, "/")) {
            $folder .= "/" ;
        }

        // stockage dans une arborescence par Date
        $folder .= date("Y/m/d/H/i/s/") ;


        if ($name == "") {
            $ext = substr($fieldUpload["name"], strrpos($fieldUpload["name"], ".")) ;
            $name = uniqid() . $ext ;
        }

        // creation du dossier
        self::mkdir($folder) ;


        // chemin vers le fichier
        $file = $folder . $name ;


        move_uploaded_file($fieldUpload["tmp_name"], BASEPATH . $file);

        return $file ;
    }




    public static function saveContent($contentTxt, $name = "", $folder = "", $isTemp = false, $create_folder_with_date = true) {
        if ($isTemp) {
            $folder = "tmp/" . $folder ;
        }

        $folder = self::$folderStorage . $folder ;

        if (!self::endsWith($folder, "/")) {
            $folder .= "/" ;
        }

        // stockage dans une arborescence par Date
        if ($create_folder_with_date) {
            $folder .= date("Y/m/d/H/i/s/");
        }

        if (self::startsWith($name, ".") || $name == "") {
            $name = uniqid() . $name ;
        }

        // creation du dossier
        self::mkdir($folder) ;

        // chemin vers le fichier
        $file = $folder . $name ;


        // sauvegarde le fichier
        file_put_contents(BASEPATH . $file, $contentTxt);

        return $file ;
    }




    public static function getFolder($folder = "") {
        $folder = self::$folderStorage . $folder ;

        if (!self::endsWith($folder, "/")) {
            $folder .= "/" ;
        }

        // stockage dans une arborescence par Date
        $folder .= date("Y/m/d/H/i/s/") ;

        // creation du dossier
        self::mkdir($folder) ;

        return $folder ;
    }

    public static function getTempFolder() {
        $folder = "tmp/" ;

        $folder = self::$folderStorage . $folder ;

        if (!self::endsWith($folder, "/")) {
            $folder .= "/" ;
        }

        // stockage dans une arborescence par Date
        $folder .= date("Y/m/d/H/i/s/") ;

        // creation du dossier
        self::mkdir($folder) ;

        return $folder ;
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    /************************************
     ******** PRIVATE FUNCTIONS *********
     ************************************/

    private static function mkdir($dirName){
        $dir = BASEPATH . $dirName ;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
            //self::mkdir_r($dir);
        }
    }

    private static function mkdir_r($dirName, $rights=0777){
        $dirs = explode('/', $dirName);
        $dir='';
        foreach ($dirs as $part) {
            $dir.=$part.'/';
            if (!is_dir($dir) && strlen($dir)>0)
                mkdir($dir, $rights);
        }
    }


    private static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    private static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }


    private static function getContentType($ext) {
        $contentType = "application/octet-stream" ;

        $ext = strtolower($ext);

        switch ($ext) {
            case "doc":
                return "application/msword" ;
                break;
            case "dot":
                return "application/msword" ;
                break;
            case "bin":
                return "application/octet-stream" ;
                break;
            case "pdf":
                return "application/pdf" ;
                break;
            case "ai":
                return "application/postscript" ;
                break;
            case "eps":
                return "application/postscript" ;
                break;
            case "ps":
                return "application/postscript" ;
                break;
            case "rtf":
                return "application/rtf" ;
                break;
            case "xls":
                return "application/vnd.ms-excel" ;
                break;
            case "xlt":
                return "application/vnd.ms-excel" ;
                break;
            case "pps":
                return "application/vnd.ms-powerpoint" ;
                break;
            case "ppt":
                return "application/vnd.ms-powerpoint" ;
                break;
            case "gz":
                return "application/x-gzip" ;
                break;
            case "tar":
                return "application/x-tar" ;
                break;
            case "zip":
                return "application/zip" ;
                break;
            case "bmp":
                return "image/bmp" ;
                break;
            case "gif":
                return "image/gif" ;
                break;
            case "png":
                return "image/png" ;
                break;
            case "jpe":
                return "image/jpeg" ;
                break;
            case "jpeg":
                return "image/jpeg" ;
                break;
            case "jpg":
                return "image/jpeg" ;
                break;
            case "svg":
                return "image/svg+xml" ;
                break;
            case "tif":
                return "image/tiff" ;
                break;
            case "tiff":
                return "image/tiff" ;
                break;
            case "css":
                return "image/css" ;
                break;
            case "htm":
                return "text/html" ;
                break;
            case "html":
                return "text/html" ;
                break;
            case "txt":
                return "text/plain" ;
                break;
        }


        return $contentType ;
    }

    private static function getContentDisposition($ext) {
        $contentDisposition = "attachment" ;

        $ext = strtolower($ext);

        switch ($ext) {
            case "gif":
                return "inline" ;
                break;
            case "png":
                return "inline" ;
                break;
            case "jpe":
                return "inline" ;
                break;
            case "jpeg":
                return "inline" ;
                break;
            case "jpg":
                return "inline" ;
                break;
            case "svg":
                return "inline" ;
                break;
            case "css":
                return "inline" ;
                break;
            case "htm":
                return "inline" ;
                break;
            case "html":
                return "inline" ;
                break;
            case "txt":
                return "inline" ;
                break;
        }


        return $contentDisposition ;
    }
}
