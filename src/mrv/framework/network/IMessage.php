<?php
/**
 * Created by PhpStorm.
 * User: Marcello
 * Date: 09/10/2016
 * Time: 00:24
 */

namespace mrv\framework\network;


interface IMessage {
    public function getProtocolVersion();
    /** @return static */
    public function withProtocolVersion($protocol);
    public function getHeaders();
    public function hasHeader($name);
    public function getHeader($name);
    /** @return static */
    public function withHeader($name, $value);
    public function getBody();
    /** @return static */
    public function withBody($body);
}