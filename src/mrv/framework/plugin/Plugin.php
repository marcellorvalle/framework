<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 02/10/2016
 * Time: 21:34
 */

namespace mrv\framework\plugin;
use mrv\framework\network\Request;

abstract class Plugin {
    public function beforeRequestProcessing(Request $request, array &$data, &$interrupt) {}
    public function afterRequestProcessing(Request $request, Response $response) {}
}