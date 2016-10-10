<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 09/10/2016
 * Time: 22:04
 */

namespace mrv\framework\plugin;


use mrv\framework\network\Response;

class PluginManager {
    private $plugins = [];
    
    public function add($name, $hook, \Closure $action) {
        $this->plugins[$hook][$name] = $action;
    }

    public function hook($name, $control) {
        $control['interrupt'] = false;

        if (isset($this->plugins[$name])) {
            foreach ($this->plugins[$name] as $pluginName => $action) {
                $control = $action($control) ?? $control;
                if ($control['interrupt']) {
                    break;
                }
            }
        }

        return $control;
    }

}