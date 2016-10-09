<?php

require('./src' . DIRECTORY_SEPARATOR . 'autoload.php');

try {
    $router = new \mrv\framework\routing\Router();
    $router->get('/example/string/{param1}', function($request,\mrv\framework\network\Response $response, $params){
        return $response->withBody(serialize($params));
    });
    $router->get('/example/array/{param1}', function($request,\mrv\framework\network\Response $response, $params){
        return $response->withBody($params);
    });

    $fc = new \mrv\framework\FrontController($router);

    echo $fc->process(\mrv\framework\network\Request::buildRequest());


} catch (\Exception $ex) {
    echo $ex->getMessage();
}

/*
 http://localhost/framework/index.php/controle2016/modules/financeiro/Controller/saldo
 */

