<?php
namespace mrv\framework\network;


class Response {
    const STATUS_OK = 200;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_NOT_FOUND = 404;
    const STATUS_INTERNAL_ERROR = 500;

    private $statusCode;
    private $statusMessage;
    private $body;

    public static function create($statusCode, $statusMessage, $body = []) {
        $response = new static;

        $response->body = $body;
        $response->statusCode = $statusCode;
        $response->statusMessage = $statusMessage;
        return $response;
    }

    public function setStatusCode($statusCode): Response {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setStatusMessage($statusMessage): Response {
        $this->statusMessage = $statusMessage;
        return $this;
    }

    public function setBody($body): Response {
        $this->body = $body;
        return $this;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function getStatusMessage() {
        return $this->statusMessage;
    }

    public function getBody() {
        return $this->body;
    }

    public function getVars() {
        return get_object_vars($this);
    }

}