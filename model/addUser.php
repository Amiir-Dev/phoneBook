<?php

include 'user.php';

class addUser extends user
{
    private $firstName;
    private $lastName;
    private $fatherName;
    private $phone_number;

    private $userData;
    private $userId;

    public function add($params)
    {
        $this->firstName = $params['f-name'];
        $this->lastName = $params['l-name'];
        $this->fatherName = $params['fa-name'];
        $this->phone_number = $params['phone_number'];

        $db = "INSERT INTO users (first_name, last_name, father_name, phone_number) VALUES (:first_name, :last_name, :father_name, :phone_number)";
        $stmt = ($this->conn)->prepare($db);
        $stmt->execute(['first_name'=>$this->firstName, 'last_name'=>$this->lastName, 'father_name'=>$this->fatherName, ':phone_number'=>$this->phone_number]);
        $this->userId = $this->conn->lastInsertId();

        # TODO (Add Numbers Into Databse)
        $this->userData = (object)["id" => $this->userId, "first_name" => $this->firstName, "last_name" => $this->lastName];
        
        return true; 
    }
}
