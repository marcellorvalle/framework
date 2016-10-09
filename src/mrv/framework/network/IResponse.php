<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 09/10/2016
 * Time: 00:33
 */

namespace mrv\framework\network;


interface IResponse extends IMessage{
    public function getStatusCode();
    public function withStatusCode($statuus, $reason = ''): IResponse;
    public function getReason();

}