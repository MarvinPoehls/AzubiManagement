<?php

class Berufsschulklasse extends BaseModel
{
    protected $id = "";
    protected $berufsschul_id = "";
    protected $name = "";
    protected $classteacher = "";
    protected $table = "berufsschulklasse";
    protected $columns = ['id', 'berufsschul_id', 'name', 'classteacher'];
}