<?php


namespace Lineten\CurlClient\Request;


use Lineten\CurlClient\CurlHandle;

/**
 * Class AllowInvalidSSL
 * @package Lineten\CurlClient\Request
 */
class AllowInvalidSSL
{
    /**
     * @param CurlHandle $handle
     */
    public function __invoke(CurlHandle $handle)
    {
        $handle->setOptions([
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
    }
}
