<?php

class Login extends Website
{
    protected $title = "Login";

    public function checkLogin()
    {
        session_start();
        $email = $this->getRequestParameter("email");
        $password = $this->getRequestParameter("password");
        if ($email !== false && $password !== false) {
            if (DatabaseConnection::isEntryValid($email, "email")) {
                $sql = "SELECT password FROM azubi WHERE email = '" . $email . "'";
                $result = DatabaseConnection::executeMysqlQuery($sql);
                $row = mysqli_fetch_row($result);
                $userPassword = $row[0];

                if (Azubi::encrypt($password) == $userPassword) {
                    $_SESSION["lastLogin"] = time();
                    $lastSite = $_SESSION["lastSite"];
                    $this->redirect($lastSite);
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }
    }
}