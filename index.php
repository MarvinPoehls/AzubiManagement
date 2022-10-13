<?php

include __DIR__ . "/autoloader.php";

$controller = "AzubiTeam";
if (isset($_REQUEST['controller'])) {
    $controller = $_REQUEST['controller'];
}

$controllerObject = new $controller();

if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
    if (method_exists($controllerObject, $action)) {
        $controllerObject->$action();
    }
}

$controllerObject->render();
