<?php


namespace TH\CurlClient\Request;


use TH\CurlClient\CurlHandle;

class Request
{
    public $url;
    public $method;

    public function __construct(string $method, string $url)
    {
        $this->url = $url;
        $this->method = $method;
    }

    public function __invoke(CurlHandle $handle)
    {
        $handle->setOptions([
            CURLOPT_URL => $this->url,
            CURLOPT_CUSTOMREQUEST => strtoupper($this->method),
        ]);
    }
}
