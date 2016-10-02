<?php

// Composer autoload
require_once 'vendor/autoload.php';

// AspectMock
ini_set("allow_url_include", "1");
$kernel = \AspectMock\Kernel::getInstance();
$kernel->init([
    'debug' => true,
    'includePaths' => [__DIR__ . '/src'],
    'excludePaths' => [__DIR__ . '/vendor', __DIR__ . '/tests'],
    'cacheDir' => __DIR__ . '/build/aspect-mock-cacheDir/',
]);
//$kernel->loadFile(__DIR__ . "autoload.php");

// Error Reporting
ini_set("error_reporting", E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_WARNING);
