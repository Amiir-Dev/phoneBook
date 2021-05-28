<?php
include "BaseModel.php";

class user extends DBConnection
{
    public $conn;
    public function __construct()
    {
        $this->conn = DBConnection::connect();
    }
}

