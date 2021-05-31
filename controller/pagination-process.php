<?php

include "../Base/constants.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    return;
}

include BASE_PATH . 'autoload.php';

$action = "get";

$className = "{$action}User";
$fileName = "{$className}.php";

if (class_exists($className)) {
    $result = (new $className())->pagination();
}

echo $result;
