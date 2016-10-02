<?php
namespace mrv\framework\network;


class Request {
    private $serverName;
    private $serverAddr;
    private $serverPort;
    private $remoteAddr;
    private $remotePort;
    private $agent;
    private $script;
    private $uri;
    private $pathinfo;
    private $method;
    private $time;
    private $accept;

    public static function buildRequest() {
        $request = new static;

        $request->serverName = $_SERVER['SERVER_NAME'];
        $request->serverAddr = $_SERVER['SERVER_ADDR'];
        $request->serverPort = $_SERVER['SERVER_PORT'];
        $request->remoteAddr = $_SERVER['REMOTE_ADDR'];
        $request->remotePort = $_SERVER['REMOTE_PORT'];
        $request->agent = $_SERVER['HTTP_USER_AGENT'];
        $request->script = $_SERVER['SCRIPT_FILENAME'];
        $request->uri = $_SERVER['REQUEST_URI'];
        $request->pathinfo = $_SERVER['PATH_INFO'] ?? null;
        $request->method = $_SERVER['REQUEST_METHOD'];
        $request->time = $_SERVER['REQUEST_TIME'];
        $request->accept = $_SERVER['HTTP_ACCEPT'] ?? null;

        return $request;
    }

    /**
     * @return mixed
     */
    public function getServerName() {
        return $this->serverName;
    }

    /**
     * @return mixed
     */
    public function getServerAddr() {
        return $this->serverAddr;
    }

    /**
     * @return mixed
     */
    public function getServerPort() {
        return $this->serverPort;
    }

    /**
     * @return mixed
     */
    public function getRemoteAddr() {
        return $this->remoteAddr;
    }


    /**
     * @return mixed
     */
    public function getRemotePort() {
        return $this->remotePort;
    }

    /**
     * @return mixed
     */
    public function getAgent() {
        return $this->agent;
    }

    /**
     * @return mixed
     */
    public function getScript() {
        return $this->script;
    }


    /**
     * @return mixed
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getPathinfo() {
        return $this->pathinfo;
    }

    /**
     * @return mixed
     */
    public function getMethod() {
        return $this->method;
    }

    public function getTime() {
        return $this->time;
    }

    public function getAccept() {
        return $this->accept;
    }


    public function isPost() {
        return $this->method === 'post';
    }

    public function isGet() {
        return $this->method === 'get';
    }

    public function getData() {
        return [];
    }

}