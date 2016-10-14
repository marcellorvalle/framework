<?php
namespace mrv\framework;


use mrv\framework\network\Request;
use mrv\framework\network\Response;
use mrv\framework\plugin\PluginManager;
use mrv\framework\routing\Router;

class FrontControllerTest extends \PHPUnit_Framework_TestCase {
    private $overridenResponse;
    private $overridenRequest;
    private $control;

    public function __construct() {
        $this->overridenRequest = Request::create()->withBody('OverridenRequest');
        $this->overridenResponse = Response::create()->withBody('OverridenResponse');
        $this->control = [
            'request' => $this->overridenRequest,
            'response' => $this->overridenResponse,
            'interrupt' => false
        ];
    }


    public function testHooks() {
        $request = Request::create();
        $router = \Phake::mock(Router::class);

        $pluginManager = \Phake::mock(PluginManager::class);
        \Phake::when($pluginManager)
            ->hook('before_routing', \Phake::ignoreRemaining())
            ->thenReturn(['request' => $request]);

        $fc = FrontController::create()->withPluginManager($pluginManager)->withRouter($router);
        $fc->process($request);

        \Phake::verify($router)->getResponse($request);
        \Phake::verify($pluginManager)->hook('before_routing', \Phake::ignsoreRemaining());
        \Phake::verify($pluginManager)->hook('after_routing', \Phake::ignoreRemaining());
        \Phake::verify($pluginManager)->hook('rendering', \Phake::ignoreRemaining());
    }

    public function testBeforeRoutingPluginOverridesRequest() {
        $pm = \Phake::mock(PluginManager::class);
        \Phake::when($pm)
            ->hook('before_routing', \Phake::ignoreRemaining())
            ->thenReturn($this->control);

        $router = \Phake::mock(Router::class);

        $fc = FrontController::create()
            ->withPluginManager($pm)
            ->withRouter($router);

        $fc->process(Request::create());
        \Phake::verify($router)->getResponse($this->overridenRequest);
    }
    
    public function testBeforeRoutingPluginInterrupts() {
        $router = \Phake::mock(Router::class);
        $pluginManager = \Phake::mock(PluginManager::class);

        $control = $this->control;
        $control['interrupt'] = true;

        \Phake::when($pluginManager)->hook('before_routing', \Phake::ignoreRemaining())->thenReturn($control);
        \Phake::when($pluginManager)->hook('after_routing', \Phake::ignoreRemaining())->thenReturn($control);

        $fc = FrontController::create()->withPluginManager($pluginManager)->withRouter($router);
        $this->assertEquals(
            $this->overridenResponse->getBody(),
            $fc->process(Request::create())
        );

        \Phake::verify($router, \Phake::never())->getResponse(\Phake::anyParameters());
        \Phake::verify($pluginManager)->hook('after_routing', $control);
    }

    public function testPluginAfterRoutingOverridesResponse() {
        $pluginManager = \Phake::mock(PluginManager::class);

        \Phake::when($pluginManager)->hook('before_routing', \Phake::ignoreRemaining())->thenReturn($this->control);
        \Phake::when($pluginManager)->hook('after_routing', \Phake::ignoreRemaining())->thenReturn($this->control);

        $fc = FrontController::create()->withPluginManager($pluginManager)->withRouter(Router::create());
        $this->assertEquals(
            $this->overridenResponse->getBody(),
            $fc->process(Request::create())
        );
    }
}