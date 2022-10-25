<?php

include __DIR__ . "/autoloader.php";

$controller = "AzubiTeam";
if (isset($_REQUEST['controller'])) {
    $controller = $_REQUEST['controller'];
}

$controllerObject = new $controller();

try {
    if (isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];
        if (method_exists($controllerObject, $action)) {
            $controllerObject->$action();
        }
    }
} catch (Exception $exception) {
    include __DIR__."/Views/userError.php";
}

try {
    $controllerObject->render();
} catch (Exception $exception) {
    include __DIR__."/Views/error.php";
}
