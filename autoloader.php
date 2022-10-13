<?php

function autoload($class) {
    $folders = [
        'Classes',
        'Controllers',
        'Models',
        'Traits',
    ];
    foreach ($folders as $folder) {
        $path = __DIR__."/".$folder."/".$class.".php";
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
    die("Class ".$class." not found!");
}

spl_autoload_register('autoload');