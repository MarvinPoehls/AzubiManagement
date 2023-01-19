<?php

abstract class JsonController extends SecureController
{
    public function render()
    {
        echo json_encode($this->getJsonData());
    }

    abstract protected function getJsonData();
}