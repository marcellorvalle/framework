<?php
namespace mrv\framework\network;


class Request extends Message implements IRequest{
    public static function buildRequest() {
        $request = new static;
        $request->headers = $_SERVER;
        return $request;
    }

    public function getRequestTarget() {
        return $this->headers['PATH_INFO'];
    }

    public function withRequestTarget($target): IRequest {
        $this->headers['PATH_INFO'] = $target;
        return $this;
    }

    public function getMethod() {
        return $this->headers['REQUEST_METHOD'];
    }

    public function withMethod($method): IRequest {
        $this->headers['REQUEST_METHOD'] = $method;
        return $this;
    }

    public function getUri() {
        return $this->headers['REQUEST_URI'];
    }

    public function withUri($uri): IRequest {
        $this->headers['REQUEST_URI'] = $uri;
        return $this;
    }
}