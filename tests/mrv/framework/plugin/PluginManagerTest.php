<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 09/10/2016
 * Time: 22:35
 */

namespace mrv\framework\plugin;


class PluginManagerTest extends \PHPUnit_Framework_TestCase {
    public function testTeste() {
        $pm = new PluginManager();

        $pm->add('consoleLog', 'before_routing',
            function($control){
                echo 'BEFORE ' . $control['request']->getURI() . '\n';
            }
        );

        $pm->add('consoleLog', 'after_routing',
            function($control){
                echo 'AFTER ' . $control['request']->getURI() . '\n';
            }
        );
    }
}