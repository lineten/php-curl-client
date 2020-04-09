<?php


namespace CurlClient\Request;


use CurlClient\CurlHandle;

class AuthBearerToken
{
    public $accessToken;

    public function __construct(string $token)
    {
        $this->accessToken = $token;
    }

    public function __invoke(CurlHandle $handle)
    {
        $handle->setHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);
    }
}