<?php
include "BaseModel.php";

// use Model\BaseModel;

class user extends BaseModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = BaseModel::connect();
    }
}

