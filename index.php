<?php

include "controller/constants.php";
include "controller/helper.php";
include "model/getUserList.php";
include "controller/process.php";

$params = $_GET ?? [];

$rows = (new getUserList())->pagination();
// var_dump($rows);

if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}

$users = (new getUserList())->getUserData();

include "view/usersList-view.php";
