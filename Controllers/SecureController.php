<?php

class SecureController extends BaseController
{
    protected $secure = false;

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
        $_SESSION["lastSite"] = $this->getRequestParameter("controller");
        $timeSinceLastLogin = (time() - $_SESSION["lastLogin"]) / 60;

        if ($timeSinceLastLogin > $maxLoggedInTime || !isset($_SESSION["lastLogin"])) {
            $this->redirect("?controller=login");
        }
    }
}