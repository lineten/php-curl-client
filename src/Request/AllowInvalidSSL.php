<?php


namespace TH\CurlClient\Request;


use TH\CurlClient\CurlHandle;

class AllowInvalidSSL
{
    public function __invoke(CurlHandle $handle)
    {
        $handle->setOptions([
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
    }
}
