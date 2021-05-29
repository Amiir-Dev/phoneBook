<?php
include "../Base/constants.php";
include BASE_PATH . "model/addUser.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    return;
}

include BASE_PATH . 'autoload.php';

$action = $_POST['action'];
$params = $_POST['data'];

if (!isset($params) or empty($params)) {
    die("پرکردن تمامی فیلدها الزامی است!");
}

$className = "{$action}User";
$fileName = "{$className}.php";

if (class_exists($className)) {
    $result = (new $className())->$action($params);
}

if($result){
    echo "مخاطب موردنظر با موفقیت افزوده شد";
}
else{
    echo "مشکلی در ثبت مخاطب موردنظر پیش آمده، مجدداً تلاش کنید!";
}