<?php
include "BaseModel.php";
class user extends BaseModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = BaseModel::connect();
    }
}

