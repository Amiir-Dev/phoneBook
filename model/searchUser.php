<?php

include 'user.php';

class searchUser extends user
{
    private $condition;
    private $keyword;

    public function search($params)
    {
        $this->keyword = $params;

        if (isset($params)) {
            $this->condition = "WHERE first_name LIKE '%{$this->keyword}%' OR last_name LIKE '%{$this->keyword}%'";
        }

        $db = "SELECT * FROM users {$this->condition}";
        $stmt = ($this->conn)->prepare($db);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
