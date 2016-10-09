<?php
namespace mrv\framework;


use mrv\framework\network\IResponse;
use mrv\framework\network\Request;
use mrv\framework\routing\Router;

class FrontController {
    private $router;

    public function __construct(Router $router) {
        $this->router = $router;
    }

    public function process(Request $request) {
        $response = $this->router->getResponse($request);
        return $this->render($response);
    }

    private function render(IResponse $response) {
        return is_string($response->getBody()) ? $response->getBody() : print_r($response->getBody());
    }
}