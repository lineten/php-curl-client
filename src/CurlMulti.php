<?php

namespace CurlClient;

/**
 * Class CurlMulti
 * @package CurlClient2
 */
class CurlMulti
{
    protected $handles = [];

    public function add(CurlRequest $req, $callback)
    {
        $clone = clone $this;
        $clone->handles[] = [$req, $callback];
        return $clone;
    }

    public function send()
    {
        $m = new Multi();
        foreach ($this->handles as $x) {
            /** @var $req CurlRequest */
            list($req, $callback) = $x;
            $handle = $req->getHandle();
            $m->add($handle->getCurlHandle(), function ($ch, $result) use ($handle, $callback) {
                $callback($handle->getResponse(), $handle);
            });
        }
        $m->run();
    }
}