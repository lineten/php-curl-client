<?php


namespace CurlClient\Request;


use CurlClient\CurlHandle;

class Authorization
{
    public $auth;

    public function __construct(string $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(CurlHandle $handle)
    {
        $handle->setHeaders([
            'Authorization' => $this->auth
        ]);
    }
}