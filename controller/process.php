<?php
include "constants.php";
include BASE_PATH . "view/removeUser.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    return;
}

include '../autoload.php';

$action = $_POST['action'];

$user_id = $_POST['userID'] ?? NULL;

$className = "{$action}User";
$fileName = "{$action}User.php";

// # Include Class File Manually 
// $filePath = BASE_URL . "model/$fileName";
// include $filePath;
// // var_dump($filePath);
// var_dump($className);

if (class_exists($className)) {
    $user = new $className();
    // var_dump($action);
    echo $user->$action($user_id);
    // var_dump($user->$action);
    // var_dump($user);
    // var_dump($user->$action);
}
else{
    echo "class not exist";
}