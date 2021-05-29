<?php

include 'user.php';

class getUserList extends user
{
    # Order Conditions
    private $orderBy;
    private $_order = '';
    private $rowInEveryPage;
    private $page;
    private $numPage;
    private $limitation;

    public function pagination()
    {
        $db = "SELECT COUNT(*) FROM users";
        $stmt = ($this->conn)->prepare($db);
        $stmt->execute();
        $record = $stmt->fetch();
        $this->rowInEveryPage = ceil((int)$record[0] / TASK_EVERY_PAGE);
        return $this->rowInEveryPage;
    }

    public function getUserData()
    {
        $this->page = isset($_GET['page']) ? $_GET['page'] : 1;

        $this->numPage = ((int) $this->page * TASK_EVERY_PAGE) - TASK_EVERY_PAGE;

        $this->orderBy  = $_GET['order'];

        if (isset($this->orderBy)) {
            $this->order = "ORDER BY last_name $this->orderBy";
        }

        $limitation = "LIMIT $this->numPage ," . TASK_EVERY_PAGE;

        $db = "SELECT * FROM users {$this->order} {$limitation}";
        $stmt = ($this->conn)->prepare($db);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
