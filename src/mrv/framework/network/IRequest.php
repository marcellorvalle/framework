<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 09/10/2016
 * Time: 00:28
 */

namespace mrv\framework\network;


interface IRequest extends IMessage {
    public function getRequestTarget();
    public function withRequestTarget($target): IRequest;
    public function getMethod();
    public function withMethod($method): IRequest;
    public function getUri();
    public function withUri($uri): IRequest;
}