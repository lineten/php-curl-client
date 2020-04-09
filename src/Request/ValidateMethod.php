<?php


namespace CurlClient\Request;


use CurlClient\CurlException;
use CurlClient\CurlHandle;

class ValidateMethod
{
    public function __invoke(CurlHandle $handle)
    {
        $options = $handle->getOptions();
        if (isset($options[CURLOPT_CUSTOMREQUEST])) {
            $method = strtoupper($options[CURLOPT_CUSTOMREQUEST]);
            if (!in_array($method, ["GET", "POST", "PUT", "DELETE", "OPTIONS", "HEAD", "TRACE", "CONNECT", "PATCH"])) {
                throw new CurlException('Method "' . $method . '" is not allowed', 0);
            }
        }
    }
}