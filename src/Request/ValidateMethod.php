<?php


namespace TH\CurlClient\Request;

use Fig\Http\Message\RequestMethodInterface;
use TH\CurlClient\CurlHandle;
use TH\CurlClient\Exception\CurlClientException;

class ValidateMethod
{
    public function __invoke(CurlHandle $handle)
    {
        $options = $handle->getOptions();
        if (isset($options[CURLOPT_CUSTOMREQUEST])) {
            $method = strtoupper($options[CURLOPT_CUSTOMREQUEST]);
            if (!in_array($method, [
                RequestMethodInterface::METHOD_GET,
                RequestMethodInterface::METHOD_POST,
                RequestMethodInterface::METHOD_PUT,
                RequestMethodInterface::METHOD_DELETE,
                RequestMethodInterface::METHOD_OPTIONS,
                RequestMethodInterface::METHOD_HEAD,
                RequestMethodInterface::METHOD_TRACE,
                RequestMethodInterface::METHOD_CONNECT,
                RequestMethodInterface::METHOD_PATCH,
            ])) {
                throw new CurlClientException('Method "' . $method . '" is not allowed', 0);
            }
        }
    }
}
