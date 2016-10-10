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

    $pm = new \mrv\framework\plugin\PluginManager();

    $pm->add('consoleLog', 'before_routing',
        function($control){
            echo 'BEFORE ' . $control['request']->getURI() . '<BR>';
        }
    );

    $pm->add('consoleLog', 'after_routing',
        function($control){
            echo 'AFTER ' . $control['request']->getURI() . '<BR>';
        }
    );

    $pm->add('html', 'rendering',
        function($control){
            $bodyData = $control['response']->getBody();
            $body = '<table style="width:100%">';
            foreach ($bodyData as $name => $value) {
                $body .= "<tr>";
                $body .= "<td>$name</td><td>$value</td>";
                $body .= "</tr>";
            }
            $body .= '</table>';
            $control['response']->withBody($body);
            return $control;
            //$control['response']->withBody(json_encode($bodyData));
        }
    );

    $fc = \mrv\framework\FrontController::create()->withRouter($router)->withPluginManager($pm);
    
    echo $fc->process(\mrv\framework\network\Request::buildRequest());

} catch (\Exception $ex) {
    echo $ex->getMessage();
}

/*
 http://localhost/framework/index.php/controle2016/modules/financeiro/Controller/saldo
 */

