<?php
namespace third_party;


use mrv\framework\network\Request;
use mrv\framework\plugin\Plugin;

class SayHello extends Plugin{
    public function beforeRequestProcessing(Request $request, array &$data, &$interrupt) {
        $data['message'] = 'Hello from plugin: ' . get_class($this);
        $interrupt = true;
    }
}