<?php
include "classes/Configuration.php";

    function getRequestParameter($key, $default = false)
    {
        if (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        }
        return $default;
    }

    function redirect($location)
    {
        header("Location: ".$location);
        exit();
    }

    function getUrl($data)
    {
        return Configuration::getConfigParameter("path").$data;
    }
