<?php

class AzubiTeam extends  Website
{
    protected $title = "Azubi Team";

    public function  getAzubiList()
    {
        $azubiIds = $this->getAllIds();
        $azubiList = [];
        foreach ($azubiIds as $id) {
            $azubiList[] = new Azubi($id);
        }
        return $azubiList;
    }
}