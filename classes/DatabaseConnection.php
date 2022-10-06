<?php

class DatabaseConnection
{
    protected static $connection = null;

    public static function getConnection()
    {
        if(self::$connection == null){
            $servername = Configuration::getConfigParameter("servername");
            $username = Configuration::getConfigParameter("username");
            $password = Configuration::getConfigParameter("password");
            $dbname = Configuration::getConfigParameter("dbname");
            self::$connection = mysqli_connect($servername, $username, $password, $dbname);

            if (!self::$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }
        }
        return self::$connection;
    }

    public static function isEntryValid($entry, $column)
    {
        $sql = "SELECT ".$column." FROM azubi";
        $result = self::executeMysqlQuery($sql);
        while ($row = mysqli_fetch_row($result)) {
            if ($row[0] == $entry) {
                return true;
            }
        }
        return false;
    }

    public static function executeMysqlQuery($query)
    {
        $result = mysqli_query(self::getConnection(), $query);
        $error = mysqli_error(self::getConnection());
        if (!empty($error)) {
            echo "<h1>Error with Query:".$query." ".$error."</h1>";
        }
        return $result;
    }

    public static function getAllIds()
    {
        $sql = "SELECT id FROM azubi";
        $result = self::executeMysqlQuery($sql);
        $array= [];
        while ($row = mysqli_fetch_row($result)) {
            $array[] = $row[0];
        }
        return $array;
    }

    public static function getAzubiData($filter, $listSize, $startpoint)
    {
        $filter = trim($filter);
        $sql = "SELECT id FROM azubi";
        if ($filter != "") {
            $sql .= " WHERE name OR email LIKE '%".$filter."%'";
        }
        $sql .= " LIMIT ".$listSize." OFFSET ".$startpoint;
        $result = DatabaseConnection::executeMysqlQuery($sql);
        while($row = mysqli_fetch_row($result)){
            $azubis[$row[0]] = new Azubi($row[0]);
        }
        return $azubis;
    }
}