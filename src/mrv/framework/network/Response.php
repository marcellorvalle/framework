<?php
namespace mrv\framework\network;


use phpDocumentor\Reflection\Types\This;

class Response extends Message implements IResponse{
    const STATUS_OK = 200;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_NOT_FOUND = 404;
    const STATUS_INTERNAL_ERROR = 500;

    private $statusCode;
    private $statusMessage;

    public static function create() {
        return new static;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function withStatusCode($status, $reason = ''): IResponse {
        $this->statusCode = $status;
        $this->statusMessage = $reason;
        return $this;
    }

    public function getReason() {
        return $this->statusMessage;
    }
}