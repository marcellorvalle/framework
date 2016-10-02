<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 29/09/2016
 * Time: 21:43
 */

namespace mrv\framework\flow;


use mrv\framework\common\Singleton;
use mrv\framework\network\Request;
use mrv\framework\network\Response;
use mrv\framework\processing\Controller;

class FrontController {
    private $router;

    public function __construct(Router $router) {
        $this->router = $router;
    }

    public function processRequest(Request $request) {
        $route = $this->router->getRoute($request);

        try {
            $data = $this->invoke($route['controller'], $route['method']);
            $response = Response::create($data);
        } catch (\Exception $ex) {
            $response = Response::create([], '400', $ex->getMessage());
        }
    }

    private function invoke(Controller $controller, $method): array {
        $controller->init();
        $controller->$method();
        $controller->finalize();
        return $controller->getData();
    }
}

/*
 http://localhost/framework/index.php/controle2016/modules/financeiro/Controller/saldo
 */