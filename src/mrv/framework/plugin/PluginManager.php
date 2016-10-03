<?php
namespace mrv\framework\plugin;

use mrv\framework\network\Request;
use mrv\framework\network\Response;

class PluginManager extends Plugin {
    private $plugins;

    public function register($fullName) {
        if (!$this->isPlugin($fullName)) {
            throw new \Exception("Not a valid plugin!");
        }

        $this->add($fullName, new $fullName);
    }

    public function add($name, Plugin $plugin) {
        $this->plugins[$name] = $plugin;
    }

    private function isPlugin($name) : bool {
        return is_subclass_of($name, Plugin::class);
    }

    public function remove($name) {
        unset($this->plugins[$name]);
    }

    public function beforeRequestProcessing(Request $request, array &$data, &$interrupt) {
        $interrupt = false;
        foreach ($this->plugins as $plugin) {
            $plugin->beforeRequestProcessing($request, $data, $interrupt);
            if ($interrupt) {
                return;
            }
        }
    }

    public function afterRequestProcessing(Request $request, Response $response) {
        foreach ($this->plugins as $plugin) {
            $plugin->afterRequestProcessing($request, $response);
        }
    }
}