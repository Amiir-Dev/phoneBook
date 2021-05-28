<?php

spl_autoload_register(function ($class) {
    $class_file = __DIR__ . "$class.php";
    $class_file = str_replace('\\', '/', $class_file);
    if (file_exists($class_file) and is_readable($class_file)) {
        include $class_file;
    } else {
        die('class file die!');
    }
});
