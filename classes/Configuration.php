<?php

class Configuration
{
    static function getParameter($name)
    {
        if (file_exists("config.php")){
            include "C:/xampp/xampp/htdocs/azubiManagement/config.php";
            if (isset($data[$name])) {
                return $data[$name];
            }
            return false;
        }
        die("Config Data is missing.");
    }
}