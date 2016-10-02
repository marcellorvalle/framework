<?php
namespace mrv\framework\network;


class Response {
    private $statusCode;
    private $statusMessage;
    private $data;

    public static function create($data = [], $statusCode = 200, $statusMessage = 'ok') {
        $response = new static;

        $response->data = $data;
        $response->statusCode = $statusCode;
        $response->statusMessage = $statusMessage;
        return $response;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function getStatusMessage() {
        return $this->statusMessage;
    }

    public function getData() {
        return $this->data;
    }

}