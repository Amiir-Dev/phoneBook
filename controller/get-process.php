<?php

include "../Base/constants.php";
include BASE_PATH . "model/getUser.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    return;
}

include BASE_PATH . 'autoload.php';

$action = $_POST['action'] ?? NULL;
$params = $_POST ?? NULL;

$className = "{$action}User";
$fileName = "{$className}.php";


if (class_exists($className)) {
    $result = (new $className())->$action($params);
}


foreach ($result as $user){
    echo 
    "<tr>
        <td> $user->first_name </td>
        <td class='text-center'> $user->last_name </td>
        <td>
            <button id='showUserInfo' class='statusToggle profile' user-id= $user->id  style='margin : 5px 0px'>مشاهده پروفایل</button>
            <button class='statusToggle' id='remove-user' user-name= $user->first_name $user->last_name  user-id= $user->id  style='margin : 5px 0px'> حذف </button>
        </td>
    </tr>";
}
