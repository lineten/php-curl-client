<?php


namespace Lineten\CurlClient\Request;


use Lineten\CurlClient\CurlHandle;

/**
 * Class AuthBearerToken
 * @package Lineten\CurlClient\Request
 */
class AuthBearerToken
{
    public $accessToken;

    /**
     * AuthBearerToken constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->accessToken = str_replace('Bearer ', '', $token);
    }

    /**
     * @param CurlHandle $handle
     */
    public function __invoke(CurlHandle $handle)
    {
        $handle->setHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);
    }
}
