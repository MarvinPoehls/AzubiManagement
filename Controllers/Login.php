<?php

class Login extends BaseController
{
    protected $title = "Login";
    protected $view = "login";
    protected $isDataWrong = false;

    public function isDataWrong()
    {
        return $this->isDataWrong;
    }

    public function checkLogin()
    {
        session_start();
        $email = $this->getRequestParameter("email");
        $password = $this->getRequestParameter("password");
        if ($email != null && $password != null) {
            if ($this->isEntryValid($email, $password)) {
                $_SESSION["lastLogin"] = time();
                $this->redirect("?controller=".$_SESSION["lastSite"]);
            }
        }
        $this->isDataWrong = true;
    }

    protected function isEntryValid($email, $password)
    {
        $sql = "SELECT * FROM azubi WHERE email = '".$email."'";
        $result = DatabaseConnection::executeMysqlQuery($sql);
        $row = mysqli_fetch_assoc($result);
        if ($row["password"] == Azubi::encrypt($password)) {
            return true;
        }
        return false;
    }

    public function logout()
    {

    }
}