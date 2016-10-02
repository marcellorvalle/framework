<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 02/10/2016
 * Time: 00:01
 */

namespace mrv\framework\flow;

use AspectMock\Test as test;
use mrv\framework\network\Request;
use mrv\framework\network\Response;
use mrv\framework\processing\Controller;
use mrv\test\TestApp;

class FrontControllerTest extends \PHPUnit_Framework_TestCase {

    public function testProcessRequest() {
        $router = \Phake::mock(Router::class);
        $request = Request::buildRequest();
        $controller = \Phake::mock(TestApp::class);
        \Phake::when($router)->getRoute($request)->thenReturn([
            'controller' => $controller,
            'method' => 'testAction'
        ]);

        $fc = new FrontController($router);
        $fc->processRequest($request);

        \Phake::verify($controller)->init();
        \Phake::verify($controller)->testAction();
        \Phake::verify($controller)->finalize();
        \Phake::verify($controller)->getData();
    }
}