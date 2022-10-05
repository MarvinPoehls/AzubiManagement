<?php

class DatabaseConnection
{
    static function getConnection()
    {
        $servername = Configuration::getParameter("servername");
        $username = Configuration::getParameter("username");
        $password = Configuration::getParameter("password");
        $dbname = Configuration::getParameter("dbname");
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $conn;
    }
}