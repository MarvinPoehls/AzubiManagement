<?php

$maxLoggedInTime = 30;

session_start();
$_SESSION["lastSite"] = $_SERVER['PHP_SELF'];
$timeSinceLastLogin = (time() - $_SESSION["lastLogin"]) / 60;

if ($timeSinceLastLogin > $maxLoggedInTime || !isset($_SESSION["lastLogin"])) {
    redirect("login.php");
}