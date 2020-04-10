<?php

namespace TH\CurlClient\Request;

use TH\CurlClient\CurlHandle;

class BodyContent
{
    public $data;

    /**
     * @param string $data
     */
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * @param CurlHandle $handle
     */
    public function __invoke(CurlHandle $handle)
    {
        $handle->setBody($this->data);
    }
}