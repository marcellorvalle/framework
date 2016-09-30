<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 29/09/2016
 * Time: 21:43
 */

namespace mrv\flow;


use mrv\network\Request;
use mrv\processing\Controller;

class FrontController {
    public static function processRequest(Request $request) {
        $action = $request->getPathinfo();

        $exploded = explode('/', $action);
        array_shift($exploded);
        $method = array_pop($exploded);
        $controllerName = '\\' . implode('\\', $exploded);
        $controller =  self::createController($controllerName, ['somedata' => 'somevalue']);
        var_dump(self::invoke($controller, $method));
    }

    private static function createController($controllerName, $data): Controller {
        if (!is_subclass_of($controllerName, Controller::class)) {
            throw new \Exception('Not a valid controller!');
        }

        return $controllerName::create($data);
    }

    private static function invoke(Controller $controller, $method): array {
        $controller->init();
        $controller->beforeAction($method);
        $controller->$method();
        $controller->afterAction($method);
        $controller->finalize();
        return $controller->getData();
    }

}

/*
 http://localhost/framework/index.php/controle2016/modules/financeiro/Controller/saldo
 *
 /