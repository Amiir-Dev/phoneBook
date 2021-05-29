<?php
include "constants.php";
include BASE_PATH . "view/removeUser.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    return;
}

include '../autoload.php';

$action = $_POST['action'];

$user_id = $_POST['userID'] ?? NULL;
$keyword = $_POST['keyword'];
$params = $_POST;

if(!isset($keyword) or empty($keyword)){
    die('نتیجه ای یافت نشد!');
}

$className = "{$action}User";
$fileName = "{$action}User.php";

if (class_exists($className)) {
    $user = new $className();
    $result = $user->$action($params);
}

if(!sizeof($result)){
    die('نتیجه ای یافت نشد!');
}

foreach($result as $res){
    echo "<a href='#'>
    <div class='result-item' user_id='$res->id'>
    <span class='user-title'> $res->first_name $res->last_name</span>
    </div>
    </a>";
}
