<?php
namespace mrv\framework\routing;


use mrv\framework\network\Request;
use mrv\framework\network\Response;

class RouterTest extends \PHPUnit_Framework_TestCase {

    public function  testGetResponseRouting() {
        $request = $this->createGetRequest();

        $mr = new Router();
        $mr->add('GET', '/examples/value1/value2',
            function(Request $request, Response $response, $parameters) {
                return $response->withStatusCode(Response::STATUS_OK, 'OK')->withBody('testGetResponse');
            }
        );

        $response = $mr->getResponse($request);
        $this->assertEquals('testGetResponse', $response->getBody());
    }

    public function  testGetResponseParsingParameters() {
        $request = $this->createGetRequest();
        $mr = new Router();

        $mr->add('GET', '/examples/{param1}/{param2}',
            function(Request $request, Response $response, $parameters) {
                $expected = ['param1' => 'value1', 'param2' => 'value2'];
                return  $response->withBody($expected === $parameters);
            }
        );

        $response = $mr->getResponse($request);
        $this->assertTrue($response->getBody());
    }

    public function testGetResponseNotFound() {
        $request = $this->createGetRequest();
        $mr = new Router();
        $response = $mr->getResponse($request);

        $this->assertEquals(Response::STATUS_NOT_FOUND, $response->getStatusCode());
        $this->assertEquals('Not Found', $response->getReason());
    }

    public function testGetResponseInternalError() {
        $request = $this->createGetRequest();
        $mr = new Router();
        $mr->add('GET', '/examples/{param1}/{param2}',
            function(Request $request, Response $response, $parameters) {
                throw new \Exception('Unexpected error');
            }
        );

        $response = $mr->getResponse($request);
        $this->assertEquals(Response::STATUS_INTERNAL_ERROR, $response->getStatusCode());
        $this->assertEquals('Unexpected error', $response->getBody());
    }

    private function createGetRequest() {
        $request = \Phake::mock(Request::class);
        \Phake::when($request)->getRequestTarget()->thenReturn('/examples/value1/value2');
        \Phake::when($request)->getMethod()->thenReturn('GET');
        return $request;
    }
}