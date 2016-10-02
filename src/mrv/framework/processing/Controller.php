<?php
namespace mrv\framework\processing;


abstract class Controller {
    protected $data;

    private function __construct() {}

    public static function create(array $data = []) {
        $controller = new static;
        $controller->data = $data;
        return $controller;
    }

    public function getData(): array {
        return $this->data;
    }

    public function __call($name, $arguments) {
        $this->doDefault($name);
    }

    public function doDefault($methodCalled) {
        throw new \Exception('Not a valid method: ' . $methodCalled);
    }

    public function init() {}
    public function finalize() {}
}