<?php
namespace mrv\framework\flow;


use mrv\framework\common\Singleton;
use mrv\framework\exceptions\RoutingException;
use mrv\framework\network\Request;
use mrv\framework\processing\Controller;

class Router {
    public function getRoute(Request $request): array {
        $route = $this->processAction($request->getPathinfo());
        $route['controller'] = $this->createController($route['controller'], $request->getData());
        $this->checkAction($route['controller'], $route['method']);

        return $route;
    }

    private function processAction($action) : array {
        $exploded = explode('/', $action);
        array_shift($exploded);
        $method = array_pop($exploded);
        $controller = '\\' . implode('\\', $exploded);

        return [
            'controller' => $controller,
            'method' => $method
        ];
    }

    private function createController($controllerName, $data): Controller {
        if (!is_subclass_of($controllerName, Controller::class)) {
            throw new RoutingException("$controllerName is not a valid controller!");
        }

        return $controllerName::create($data);
    }

    private function checkAction($controller, $method) {
        if (!method_exists($controller, $method)) {
            throw new RoutingException("$controller::$method is not a valid action!");
        }
    }

}