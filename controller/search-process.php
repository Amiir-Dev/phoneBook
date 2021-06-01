<?php
include "../Base/constants.php";
include BASE_PATH . "model/searchUser.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    return;
}

include BASE_PATH . 'autoload.php';

$action = $_POST['action'];
$params = $_POST['keyword'];

if (!isset($params) or empty($params)) {
    die("<div style='color: #9a2929;'> مقدار جستجو نمیتواند خالی باشد! </div>");
}

$className = "{$action}User";
$fileName = "{$className}.php";

if (class_exists($className)) {
    $result = (new $className())->$action($params);
}

if (!sizeof($result)) {
    die("<div style='color: #9a2929;'> نتیجه ای یافت نشد </div>");
}

foreach ($result as $res) {
    echo "<a>
    <div class='result-item' user_id='$res->id'>
    <span id = 'search_result' class='user-title'> $res->first_name $res->last_name</span>
    </div>
    </a>";
}
