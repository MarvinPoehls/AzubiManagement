<?php

class SecureWebsite extends Website
{
    protected $secure = true;

    public function __construct()
    {
        if($this->secure){
            $this->loginCheck();
        }
    }

    public function loginCheck()
    {
        $maxLoggedInTime = 30;

        session_start();
        $_SESSION["lastSite"] = $_SERVER['PHP_SELF'];
        $timeSinceLastLogin = (time() - $_SESSION["lastLogin"]) / 60;

        if ($timeSinceLastLogin > $maxLoggedInTime || !isset($_SESSION["lastLogin"])) {
            $this->redirect("login.php");
        }
    }
}