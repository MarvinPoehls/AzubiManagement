<?php

class AzubiTeam extends BaseController
{
    use GetAllIds;

    protected $title = "Azubi Team";
    protected $view = "fatchipTeam";

    public function getAzubiList()
    {
        $azubiIds = $this->getIds();
        $azubiList = [];
        foreach ($azubiIds as $id) {
            $azubiList[] = new Azubi($id);
        }
        return $azubiList;
    }
}