<?php

spl_autoload_register(function($class) {
    $ds = DIRECTORY_SEPARATOR;
    $filename = __DIR__ . $ds . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($filename)) {
        require $filename;
        return true;
    }

    return false;
});
