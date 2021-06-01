<?php

include 'user.php';

class updateUser extends user
{
    private $firstName;
    private $lastName;
    private $fatherName;
    private $phone_number;

    private $userData;
    private $userID;

    public function update($params)
    {
        var_dump($params);
        $this->userID = $params['thisUser-ID'];
        $this->firstName = $params['f-name'];
        $this->lastName = $params['l-name'];
        $this->fatherName = $params['fa-name'];
        $this->phone_number = $params['phone_number'];

        $db = "UPDATE users SET first_name=:first_name, last_name=:last_name, father_name=:father_name, phone_number=:phone_number WHERE id = :user_id";
        $stmt = ($this->conn)->prepare($db);
        $stmt->execute(['first_name' => $this->firstName, 'last_name' => $this->lastName, 'father_name' => $this->fatherName, ':phone_number' => $this->phone_number, ":user_id" => $this->userID]);
        return $stmt->rowcount();

        # TODO (Update Numbers In Databse)
        // $this->userData = (object)["id" => $this->userId, "first_name" => $this->firstName, "last_name" => $this->lastName];

        // return $this->userId;
    }
}
