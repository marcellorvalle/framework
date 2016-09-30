<?php

require('./src' . DIRECTORY_SEPARATOR . 'autoload.php');

try {
    $atoa = 0;
    $request = \mrv\network\Request::buildRequest();
    \mrv\flow\FrontController::processRequest($request);
} catch (\Exception $ex) {
    echo $ex->getMessage();
}

