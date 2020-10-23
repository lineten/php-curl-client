<?php


namespace Lineten\CurlClient\Request;

use Lineten\CurlClient\Constant\HttpRequestHeader;
use Lineten\CurlClient\CurlHandle;

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
