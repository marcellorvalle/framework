<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 29/09/2016
 * Time: 15:14
 */

namespace mrv\network;


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

    private function __construct() { }

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
        $request->pathinfo = $_SERVER['PATH_INFO'];
        $request->method = $_SERVER['REQUEST_METHOD'];
        $request->time = $_SERVER['REQUEST_TIME'];

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

    /**
     * @return mixed
     */
    public function getTime() {
        return $this->time;
    }

    public function isPost() {
        return $this->method === 'post';
    }

    public function isGet() {
        return $this->method === 'get';
    }

}