<?php

class KeplerDebug {

    public function __construct() {

        //
    }

    public static function debugLog(?string $string = null) { 

        $fileName = date("j-n-Y").'.txt';
        $filePath = plugin_dir_path(__DIR__ . '/../Kepler.php'). 'logs/' . $fileName;

        if (file_exists($filePath)) {
            file_put_contents($filePath, $string, FILE_APPEND);
        } else {
            file_put_contents($filePath, $string);
        }
    }
}