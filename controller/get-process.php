<?php

// echo "get-process FILE";
include "../Base/constants.php";
// include BASE_PATH . "model/getUser.php";
// include BASE_PATH . "model/findUser.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    return;
}

include BASE_PATH . 'autoload.php';

$action = $_POST['action'] ?? NULL;
$params = $_POST ?? NULL;

$className = "{$action}User";
$fileName = "{$className}.php";


if (class_exists($className)) {
    $result = (new $className())->$action($params['data']);
}

header('Content-Type: application/json');
echo json_encode($result);

