<?php

include 'user.php';
// echo "this is class File" . PHP_EOL;

class removeUser extends user
{
    private $userID;

    public function remove($params)
    {
        $this->userID = $params;
        
        $db = "DELETE FROM users WHERE id = :user_id";
        $stmt = ($this->conn)->prepare($db);
        $stmt->execute([':user_id' => $this->userID]);
        $userDataTable = $stmt->rowcount();

        $db = "DELETE FROM numbers WHERE user_id = :user_id";
        $stmt = ($this->conn)->prepare($db);
        $stmt->execute([':user_id' => $this->userID]);
        $usernumberTable = $stmt->rowcount();

        if(!$userDataTable){
            return "کاربر موردنظر یافت نشد!";
        }

        return true;
    }
}
