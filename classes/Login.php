<?php

class Login extends Website
{
    protected $title = "Login";

    public function checkLogin()
    {
        session_start();
        $email = $this->getRequestParameter("email");
        $password = $this->getRequestParameter("password");
        if ($email != null && $password != null) {
            if (!$this->isEntryValid($email, $password)) {
                return true;
            }
            $_SESSION["lastLogin"] = time();
            $lastSite = $_SESSION["lastSite"];
            $this->redirect($lastSite);
        }
        return false;
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
}