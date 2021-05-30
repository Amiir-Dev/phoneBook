<?php

include 'user.php';

class getUser extends user
{
    # Order Conditions
    private $orderBy;
    private $_order;
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

    public function get($params)
    {
        #set default
        $this->order = "created_at DESC";

        if (in_array($params['data'], ["ASC", "DESC"])) {
            $this->orderBy = $params['data'];

            if (isset($this->orderBy)) {
                $this->order = "last_name $this->orderBy";
            }
        }
        
        $this->page = is_numeric($params['data']) ? $params['data'] : 1;

        $this->numPage = ((int) $this->page * TASK_EVERY_PAGE) - TASK_EVERY_PAGE;
        // $this->page = isset($_GET['page']) ? $_GET['page'] : 1;

        // $this->numPage = ((int) $this->page * TASK_EVERY_PAGE) - TASK_EVERY_PAGE;


        $limitation = "LIMIT $this->numPage ," . TASK_EVERY_PAGE;

        $db = "SELECT * FROM users ORDER BY {$this->order} {$limitation}";
        $stmt = ($this->conn)->prepare($db);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
