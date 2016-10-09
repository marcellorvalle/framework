<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 09/10/2016
 * Time: 01:04
 */

namespace mrv\framework\network;


abstract class Message implements IMessage {
    protected $headers;
    private $body;

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
        return $this;
    }
}