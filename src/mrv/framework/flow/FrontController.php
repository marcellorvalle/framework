<?php
namespace mrv\framework\flow;

use mrv\framework\network\Request;
use mrv\framework\network\Response;
use mrv\framework\plugin\PluginManager;
use mrv\framework\processing\Controller;

class FrontController {
    private $router;
    private $pluginManager;

    public function __construct(Router $router, PluginManager $pManager) {
        $this->router = $router;
        $this->pluginManager = $pManager;
    }

    public function processRequest(Request $request) : string {
        try {
            $data = $this->beforeProcessing($request);
            if (!$data) {
                $data = $this->tryProcessRequest($request);    
            }
            
            $response = Response::create($data);
        } catch (\Exception $ex) {
            $response = Response::create([], '400', $ex->getMessage());
        }
        $this->afterProcessing($request, $response);

        return $this->render($response);
    }

    private function tryProcessRequest($request): array {
        $route = $this->router->getRoute($request);
        return $this->invoke($route['controller'], $route['method']);
    }

    private function beforeProcessing(Request $request) {
        $data = [];
        $interrupt = false;
        $this->pluginManager->beforeRequestProcessing($request, $data, $interrupt);
        return $interrupt ? $data : false;
    }

    private function afterProcessing($request, $response) {
        $this->pluginManager->afterRequestProcessing($request, $response);
    }

    private function invoke(Controller $controller, $method): array {
        //PLUGIN: beforeControllerInitialization
        $controller->init();
        //PLUGIN: beforeAction
        $controller->$method();
        //PLUGIN afterAction
        $controller->finalize();
        $data = $controller->getData();
        //PLUGIN After controlledFinalizaton
        return $data;
    }

    private function render(Response $response) : string {
        //PLUGIN BeforeResponseRendering
        return json_encode($response->getVars());
    }
}