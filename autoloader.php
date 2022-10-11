<?php
spl_autoload_register(function ($name) {
    $file = __DIR__.'/classes/'.$name.'.php';
    if (file_exists($file)) {
        require_once($file);
    }
});