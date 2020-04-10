<?php

namespace TH\CurlClient;

/**
 * Class CurlMulti
 * @package CurlClient2
 */
class CurlMulti
{
    protected $handles = [];

    public function add(CurlRequest $req, callable $callback)
    {
        $clone = clone $this;
        $clone->handles[] = [$req, $callback];
        return $clone;
    }

    public function send()
    {
        $m = new \TH\CurlMulti\CurlMulti();
        foreach ($this->handles as $x) {
            /** @var $req CurlRequest */
            list($req, $callback) = $x;
            $handle = $req->getHandle();
            $m->add($handle->ch, function () use ($handle, $callback) {
                call_user_func($callback, $handle->getResponse(), $handle);
            });
        }
        $m->run();
    }
}
