<?php

include 'user.php';

class findUser extends user
{
    private $userID;

    public function find($params)
    {
        $this->userID = $params;
        
        $db = "SELECT * FROM users WHERE id = :user_id";
        $stmt = ($this->conn)->prepare($db);    
        $stmt->execute([':user_id' => $this->userID]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
