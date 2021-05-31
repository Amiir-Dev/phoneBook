<?php

// echo "get-process FILE";
include "../Base/constants.php";
// include BASE_PATH . "model/getUser.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    return;
}

include BASE_PATH . 'autoload.php';

$action = $_POST['action'] ?? NULL;
$params = $_POST ?? NULL;

// print_r($params['data'][1]);

$className = "{$action}User";
$fileName = "{$className}.php";


if (class_exists($className)) {
    $result = (new $className())->$action($params['data']);
}

header('Content-Type: application/json');
echo json_encode($result);

