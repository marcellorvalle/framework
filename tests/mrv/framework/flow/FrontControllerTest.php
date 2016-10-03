<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 02/10/2016
 * Time: 00:01
 */

namespace mrv\framework\flow;

use mrv\framework\network\Request;
use mrv\framework\network\Response;
use mrv\framework\plugin\Plugin;
use mrv\framework\plugin\PluginManager;
use mrv\framework\processing\Controller;
use mrv\test\TestApp;

class FrontControllerTest extends \PHPUnit_Framework_TestCase {

    public function testProcessRequest() {
        $request = Request::buildRequest();
        $controller = \Phake::mock(TestApp::class);

        $router = \Phake::mock(Router::class);
        \Phake::when($router)->getRoute($request)->thenReturn([
            'controller' => $controller,
            'method' => 'testAction'
        ]);

        $fc = new FrontController($router, new PluginManager());
        $fc->processRequest($request);

        \Phake::verify($controller)->init();
        \Phake::verify($controller)->testAction();
        \Phake::verify($controller)->finalize();
        \Phake::verify($controller)->getData();
    }

    public function testProcessRequestInterrupt() {
        $pluginManager = new PluginManager();
        $pluginManager->add('interrupt', new Class($this) extends Plugin{
            private $phpunit;

            public function __construct($test) {
                $this->phpunit = $test;
            }

            public function beforeRequestProcessing($request, &$data, &$interrupt) {
                $data['test'] = true;
                $interrupt = true;
            }

            public function afterRequestProcessing($request, $response) {
                $this->phpunit->assertTrue($response->getData()['test']);
            }
        });



        $router = \Phake::mock(Router::class);
        \Phake::verify($router, \Phake::never())->getRooute();

        $fc = new FrontController($router, $pluginManager);
        $fc->processRequest(Request::buildRequest());
    }
}