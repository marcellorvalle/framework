<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 08/10/2016
 * Time: 22:12
 */

namespace mrv\framework\routing;

use mrv\framework\network\Request;
use mrv\framework\network\Response;

class ActionWrapper {
    private $action;
    private $request;
    private $params;

    public static function create (\Closure $action, Request $request, array $params): ActionWrapper {
        $wrapper = new ActionWrapper();
        $wrapper->action = $action;
        $wrapper->request = $request;
        $wrapper->params = $params;

        return $wrapper;
    }

    public function call(): Response {
        try {
            return $this->tryCallAction();
        } catch (\Exception $ex) {
            return Response::create()
                ->withStatusCode(Response::STATUS_INTERNAL_ERROR, 'Internal Server Error')
                ->withBody($ex->getMessage());
        }
    }

    private function tryCallAction() {
        $params = $this->removeNumericIndexes();
        $response = Response::create(Response::STATUS_OK, 'OK');
        $action = $this->action;

        return $action($this->request, $response, $params);
    }

    private function removeNumericIndexes() : array {
        return array_filter($this->params, function($key) {
            return is_string($key);
        }, ARRAY_FILTER_USE_KEY);
    }
}