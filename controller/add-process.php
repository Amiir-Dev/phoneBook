<?php
include "../Base/constants.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    return;
}

include BASE_PATH . 'autoload.php';

$params = $_POST;

is_numeric($params['thisUser-ID']) ? $action = "update" : $action = "add";

if (!isset($params) or empty($params)) {
    die("پرکردن تمامی فیلدها الزامی است!");
}

$className = "{$action}User";
$fileName = "{$className}.php";

if (class_exists($className)) {
    $result = (new $className())->$action($params);
}

return $result;
