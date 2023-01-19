<?php

class LoadNextAzubi extends JsonController
{
    protected function getJsonData()
    {
        return $this->getNextAzubi();
    }

    private function getNextAzubi()
    {
        $azubis = $this->getAzubiData($this->getRequestParameter("listSize", 10));
        $nextAzubi = end($azubis);
        return [$nextAzubi->getId(), $nextAzubi->getName(), $nextAzubi->getBirthday(), $nextAzubi->getEmail()];
    }

    private function getAzubiData($size = 10)
    {
        $filter = $this->getFilter();
        $startpoint = $this->getStartpoint();
        $listSize = $this->getRequestParameter("listSize", $size);
        $filter = trim($filter);
        $sql = "SELECT id FROM azubi";
        if ($filter != "") {
            $sql .= " WHERE name LIKE '%".$filter."%' OR email LIKE '%".$filter."%'";
        }
        $sql .= " LIMIT ".$listSize." OFFSET ".$startpoint;
        $result = DatabaseConnection::executeMysqlQuery($sql);
        while ($row = mysqli_fetch_row($result)) {
            $azubis[$row[0]] = new Azubi($row[0]);
        }
        return $azubis;
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
}