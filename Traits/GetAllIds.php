<?php
trait GetAllIds
{
    protected $idCount;
    protected $ids;

    public function getIds()
    {
        if ($this->ids == null) {
            $sql = "SELECT id FROM azubi";
            $result = DatabaseConnection::executeMysqlQuery($sql);
            while ($row = mysqli_fetch_row($result)) {
                $this->ids[] = $row[0];
            }
        }
        return $this->ids;
    }

    public function countIds()
    {
        if ($this->idCount == null) {
            $sql = "SELECT count(id) FROM azubi";
            $result = DatabaseConnection::executeMysqlQuery($sql);
            $row = mysqli_fetch_row($result);
            $this->idCount = $row[0];
            return $this->idCount;
        }
        return $this->idCount;
    }
}