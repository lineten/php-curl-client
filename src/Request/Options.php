<?php


namespace Lineten\CurlClient\Request;


use Lineten\CurlClient\CurlHandle;

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
