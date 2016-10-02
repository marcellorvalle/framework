<?php
namespace mrv\framework\flow;


use AspectMock\Test as test;
use mrv\framework\exceptions\RoutingException;
use mrv\framework\network\Request;
use mrv\framework\processing\Controller;
use mrv\test\TestApp;

class RouterTest extends \PHPUnit_Framework_TestCase {
    public function testGetRoute() {
        $request = \Phake::mock(Request::class);
        \Phake::when($request)->getPathinfo()->thenReturn('/mrv/test/TestApp/testAction');
        \Phake::when($request)->getData()->thenReturn($this->getData());
        $controller = test::double(Controller::class);

        $router = new Router();
        $route = $router->getRoute($request);

        $controller->verifyInvoked('create', [$this->getData()]);
        $this->assertInstanceOf(TestApp::class, $route['controller']);
        $this->assertEquals('testAction', $route['method']);
    }

    private function getData() {
        return [
            'value1' => 'a',
            'value2' => 'b',
            'value 3' => 'c'
        ];
    }

    public function testGetRouteThrowsExceptionOnInvalidAction() {
        $request = \Phake::mock(Request::class);
        \Phake::when($request)->getPathinfo()->thenReturn('/some/invalid/action');

        $this->expectException(RoutingException::class);
        $router = new Router();
        $router->getRoute($request);
    }

    protected function tearDown() {
        test::clean();
    }

}