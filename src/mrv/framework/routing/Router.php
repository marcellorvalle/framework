<?php
namespace mrv\framework\routing;


use mrv\framework\network\Request;
use mrv\framework\network\Response;

class Router {
    private $routes = [];

    public function get($uri, \Closure $action) {
        $this->add('get', $uri, $action);
    }

    public function post($uri, \Closure $action) {
        $this->add('post', $uri, $action);
    }

    public function delete($uri, \Closure $action) {
        $this->add('delete', $uri, $action);
    }

    public function add($method, $uri, \Closure $action) {
        $this->routes[strtoupper($method)][$uri] = $action;
    }

    private function buildPattern($uri) {
        $pattern = preg_replace(
            '/{([a-zA-Z0-9\_\-]+)}/',
            '(?<$1>[a-zA-Z0-9\_\-]+)',
            $uri
        );

        return "@^$pattern/?$@D";
    }

    public function getResponse(Request $request) : Response {
        $method = strtoupper($request->getMethod());

        foreach ($this->routes[$method] as $uri => $action) {
            $pattern = $this->buildPattern($uri);
            if (preg_match($pattern, $request->getPathinfo(), $params)) {
                return ActionWrapper::create($action, $request, $params)->call();
            }
        }

        return Response::create(Response::STATUS_NOT_FOUND, 'Not Found');
    }
}