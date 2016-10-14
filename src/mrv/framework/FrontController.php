<?php
namespace mrv\framework;


use mrv\framework\network\IResponse;
use mrv\framework\network\Request;
use mrv\framework\network\Response;
use mrv\framework\plugin\PluginManager;
use mrv\framework\routing\Router;

class FrontController {
    private $router;
    private $pluginManager;

    public static function create(): FrontController {
        return new FrontController();
    }

    public function withRouter(Router $router): FrontController {
        $this->router = $router;
        return $this;
    }

    public function withPluginManager(PluginManager $pm): FrontController {
        $this->pluginManager = $pm;
        return $this;
    }

    public function process(Request $request) {
        $control = ['request' => $request];
        $control = $this->doHook('before_routing', $control);

        if (!$control['interrupt']) {
            $control['response'] = $this->router->getResponse($control['request']);
        }

        $control = $this->doHook('after_routing', $control);
        $response = $control['response'] ?? Response::create()->withStatusCode(Response::STATUS_BAD_REQUEST);
        
        return $this->render($response);
    }

    private function render(IResponse $response) {
        $this->doHook('rendering', ['response' => $response]);
        return $response->getBody();
    }

    private function doHook($hookName, $control) {
        if (isset($this->pluginManager)) {
            $control = $this->pluginManager->hook($hookName, $control);
        }
        return $control;
    }
}