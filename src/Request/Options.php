<?php


namespace TH\CurlClient\Request;


use TH\CurlClient\CurlHandle;

class Options
{
    public $options = [];

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function __invoke(CurlHandle $handle)
    {
        $handle->setOptions($this->options);
    }
}
