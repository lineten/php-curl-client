<?php


namespace CurlClient\Request;

use CurlClient\CurlHandle;

class Headers
{
    public $headers = [];

    public function __construct($headers)
    {
        $this->headers = $headers;
    }

    public function __invoke(CurlHandle $handle)
    {
        $handle->setHeaders($this->headers);
    }
}