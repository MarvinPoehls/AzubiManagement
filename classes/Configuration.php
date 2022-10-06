<?php

class Configuration
{
    protected static $data = null;

    public static function getConfigParameter($name)
    {
        if (file_exists("config.php")){
            if(self::$data == null){
                include __DIR__."/../config.php";
                if(isset($data)){
                    self::$data = $data;
                }
            }
            if (isset(self::$data[$name])) {
                return self::$data[$name];
            }
            return false;
        }
        die("Config Data is missing.");
    }
}