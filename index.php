<?php

require('./src' . DIRECTORY_SEPARATOR . 'autoload.php');

try {
    $req = \mrv\framework\network\Request::buildRequest();

} catch (\Exception $ex) {
    echo $ex->getMessage();
}

/*
 http://localhost/framework/index.php/controle2016/modules/financeiro/Controller/saldo
 */

