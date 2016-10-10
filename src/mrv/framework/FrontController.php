<?php
namespace mrv\framework;


use mrv\framework\network\IResponse;
use mrv\framework\network\Request;
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
        $control = $this->doHook('before_routing', ['request' => $request]);

        if ($control['interrupt']) {
            $response = $control['response'];
        } else {
            $response = $this->router->getResponse($request);
        }

        $this->doHook('after_routing', ['request' => $request, 'response' => $response]);

        return $this->render($response);
    }

    private function render(IResponse $response) {
        $this->doHook('rendering', ['response' => $response]);
        return is_string($response->getBody()) ? $response->getBody() : print_r($response->getBody());
    }

    private function doHook($hookName, $control) {
        if (isset($this->pluginManager)) {
            $control = $this->pluginManager->hook($hookName, $control);
        }
        return $control;
    }
}