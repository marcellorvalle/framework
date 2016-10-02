<?php

require('./src' . DIRECTORY_SEPARATOR . 'autoload.php');

try {
    $atoa = 0;
    $request = \mrv\framework\network\Request::buildRequest();
    \mrv\framework\flow\FrontController::processRequest($request);
} catch (\Exception $ex) {
    echo $ex->getMessage();
}

