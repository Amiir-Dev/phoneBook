<?php
include "../Base/constants.php";
include BASE_PATH . "model/removeUser.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    return;
}

include BASE_PATH . 'autoload.php';

$action = $_POST['action'];
$params = $_POST['userID'];


$className = "{$action}User";
$fileName = "{$className}.php";

if (class_exists($className)) {
    echo (new $className())->$action($params);
}

