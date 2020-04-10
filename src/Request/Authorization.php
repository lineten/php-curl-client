<?php


namespace TH\CurlClient\Request;

use TH\Constants\HttpRequestHeader;
use TH\CurlClient\CurlHandle;

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
            HttpRequestHeader::AUTHORIZATION => $this->auth
        ]);
    }
}
