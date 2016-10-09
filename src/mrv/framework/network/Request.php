<?php
namespace mrv\framework\network;


class Request implements IRequest{
    private $headers;
    private $body;


    public static function buildRequest() {
        $request = new static;
        $request->headers = $_SERVER;
        return $request;
    }

    public function getProtocolVersion() {
        return $this->headers['SERVER_PROTOCOL'];
    }

    /** @return static */
    public function withProtocolVersion($protocol) {
        $this->headers['SERVER_PROTOCOL'] = $protocol;
        return $this;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function hasHeader($name) {
        return isset($this->headers[$name]);
    }

    public function getHeader($name) {
        return $this->headers[$name];
    }

    /** @return static */
    public function withHeader($name, $value) {
        $this->$this->headers[$name] = $value;
        return $this;
    }

    public function getBody() {
        return $this->body;
    }

    /** @return static */
    public function withBody($body) {
        $this->body = $body;
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