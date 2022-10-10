<?php

class Website
{
    protected $title = "Azubi Portal";

    public function getRequestParameter($key, $default = false)
    {
        if (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        }
        return $default;
    }

    public function redirect($location)
    {
        header("Location: " . $location);
        exit();
    }

    public function getUrl($data)
    {
        return Configuration::getConfigParameter("path") . $data;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getAllIds()
    {
        $sql = "SELECT id FROM azubi";
        $result = DatabaseConnection::executeMysqlQuery($sql);
        $array= [];
        while ($row = mysqli_fetch_row($result)) {
            $array[] = $row[0];
        }
        return $array;
    }
}