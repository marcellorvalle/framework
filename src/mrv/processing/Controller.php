<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 29/09/2016
 * Time: 22:08
 */

namespace mrv\processing;


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
    public function beforeAction($method) {}
    public function afterAction($method) {}
    public function finalize() {}
}