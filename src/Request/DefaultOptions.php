<?php


namespace TH\CurlClient\Request;


use TH\CurlClient\CurlHandle;

class DefaultOptions
{
    public function __invoke(CurlHandle $handle)
    {
        $handle->setOptions([
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HEADER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_MAXREDIRS => 3,
            //CURLOPT_USERAGENT => "thlib/CurlClient",
            //CURLOPT_REFERER => "https://github.com/thlib/php-curl-client",
            CURLOPT_ENCODING => 'gzip'
        ]);
    }
}
