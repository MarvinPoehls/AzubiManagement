<?php

class AzubiList extends SecureWebsite
{
    protected $title = "Azubi Liste";

    public function checkDelete($azubis)
    {
        if ($this->getRequestParameter("deleteId") !== false) {
            $azubis[$this->getRequestParameter("deleteId")]->delete();
            $this->redirect("azubiList.php");
        }

        foreach ($azubis as $azubi) {
            if ($this->getRequestParameter($azubi->getId()) == "on") {
                $azubi->delete();
                $this->redirect("azubiList.php");
            }
        }
    }

    public function getStartpoint()
    {
        if ($this->getRequestParameter("startpoint")) {
            return $this->getRequestParameter("startpoint");
        }
        return 0;
    }

    public function getFilter()
    {
        if ($this->getRequestParameter("filter")) {
            return $this->getRequestParameter("filter");
        }
            return " ";
    }

    public function getAzubiData()
    {
        $filter = $this->getFilter();
        $startpoint = $this->getStartpoint();
        $listSize = $this->getRequestParameter("listSize", 10);
        $filter = trim($filter);
        $sql = "SELECT id FROM azubi";
        if ($filter != "") {
            $sql .= " WHERE name OR email LIKE '%".$filter."%'";
        }
        $sql .= " LIMIT ".$listSize." OFFSET ".$startpoint;
        $result = DatabaseConnection::executeMysqlQuery($sql);
        while ($row = mysqli_fetch_row($result)) {
            $azubis[$row[0]] = new Azubi($row[0]);
        }
        return $azubis;
    }
}