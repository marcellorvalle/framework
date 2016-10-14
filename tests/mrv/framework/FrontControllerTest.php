<?php
namespace mrv\framework;


use mrv\framework\network\Request;
use mrv\framework\network\Response;
use mrv\framework\plugin\PluginManager;
use mrv\framework\routing\Router;

class FrontControllerTest extends \PHPUnit_Framework_TestCase {
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
        \Phake::verify($pluginManager)->hook('before_routing', \Phake::ignoreRemaining());
        \Phake::verify($pluginManager)->hook('after_routing', \Phake::ignoreRemaining());
        \Phake::verify($pluginManager)->hook('rendering', \Phake::ignoreRemaining());
    }
    
    public function testInterruptRouting() {
        $output = 'TEST';
        $response = Response::create()->withBody($output);
        $router = \Phake::mock(Router::class);
        $pluginManager = \Phake::mock(PluginManager::class);

        $control = [
            'interrupt' => true,
            'response' => $response
        ];

        \Phake::when($pluginManager)->hook('before_routing', \Phake::ignoreRemaining())->thenReturn($control);

        $fc = FrontController::create()->withPluginManager($pluginManager)->withRouter($router);
        $this->assertEquals('TEST', $fc->process(Request::create()));
        \Phake::verify($router, \Phake::never())->getResponse(\Phake::anyParameters());
    }

}