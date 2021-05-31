<?php
include "../Base/constants.php";
// include BASE_PATH . "model/addUser.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    return;
}

include BASE_PATH . 'autoload.php';

$action = "add";
$params = $_POST;

if (!isset($params) or empty($params)) {
    die("پرکردن تمامی فیلدها الزامی است!");
}

$className = "{$action}User";
$fileName = "{$className}.php";

if (class_exists($className)) {
    $result = (new $className())->$action($params);
}

return $result;
