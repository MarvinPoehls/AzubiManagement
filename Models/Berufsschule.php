<?php

class Berufsschule extends BaseModel
{
    protected $id = "";
    protected $name = "";
    protected $address = "";
    protected $street = "";
    protected $city = "";
    protected $zip = "";
    protected $headmaster = "";
    protected $table = "berufsschule";
    protected $columns = ['id', 'name', 'address', 'street', 'city', 'zip', 'headmaster'];
}