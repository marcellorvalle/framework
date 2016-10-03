<?php

require('./src' . DIRECTORY_SEPARATOR . 'autoload.php');

try {

    $router = new \mrv\framework\flow\Router();
    $pm = new \mrv\framework\plugin\PluginManager();
    $pm->add('\\third_party\\SayHello');


    $fc = new \mrv\framework\flow\FrontController($router, $pm);
    $request = \mrv\framework\network\Request::buildRequest();
    echo $fc->processRequest($request);
} catch (\Exception $ex) {
    echo $ex->getMessage();
}

/*
 http://localhost/framework/index.php/controle2016/modules/financeiro/Controller/saldo
 */

