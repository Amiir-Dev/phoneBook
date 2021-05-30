<?php

include 'user.php';

class addUser extends user
{
    private $firstName;
    private $lastName;
    private $fatherName;
    private $numbers;

    private $userData;
    private $userId;

    public function add($params)
    {
        $this->firstName = $params['f-name'];
        $this->lastName = $params['l-name'];
        $this->fatherName = $params['fa-name'];

        $db = "INSERT INTO users (first_name, last_name, father_name) VALUES (:first_name, :last_name, :father_name)";
        $stmt = ($this->conn)->prepare($db);
        $stmt->execute(['first_name'=>$this->firstName, 'last_name'=>$this->lastName, 'father_name'=>$this->fatherName]);
        $this->userId = $this->conn->lastInsertId();

        # Add Numbers Into Databse

        $this->userData = (object)["id" => $this->userId, "first_name" => $this->firstName, "last_name" => $this->lastName];
        
        return true; 
    }
}
