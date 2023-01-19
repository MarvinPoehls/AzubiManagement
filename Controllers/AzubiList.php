<?php

class AzubiList extends SecureController
{
    use GetAllIds;

    protected $title = "Azubi Liste";
    protected $view = "azubiList";
    protected $listSize;
    protected $sizes = [1,2,5,10,20];

    public function __construct()
    {
        if($this->secure){
            $this->loginCheck();
        }
        $this->listSize = $this->getRequestParameter("listSize", 10);
    }

    public function getSizes()
    {
        return $this->sizes;
    }

    public function getListSize()
    {
        return $this->listSize;
    }

    public function setListSize($listSize): void
    {
        $this->listSize = $listSize;
    }

    public function delete()
    {
        $azubi = new Azubi($this->getRequestParameter("deleteId"));
        $azubi->delete();
    }

    public function deleteAllChecked()
    {
        $azubis = $this->getAzubiData(count($this->getIds()));
        foreach ($azubis as $azubi) {
            if ($this->getRequestParameter($azubi->getId()) == "on") {
                $azubi->delete();
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

    public function getAzubiData($size = 10)
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
        $azubis = [];
        while ($row = mysqli_fetch_row($result)) {
            $azubis[$row[0]] = new Azubi($row[0]);
        }
        return $azubis;
    }
}