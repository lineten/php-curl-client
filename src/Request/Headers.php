<?php


namespace Lineten\CurlClient\Request;

use Lineten\CurlClient\CurlHandle;

class Headers
{
    public $headers = [];

    /**
     * Headers constructor.
     * @param $headers
     */
    public function __construct($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @param CurlHandle $handle
     */
    public function __invoke(CurlHandle $handle)
    {
        if (is_array($this->headers)) {
            foreach ($this->headers as $header) {
                $parts = explode(':', $header, 2);
                if (isset($parts[0]) && isset($parts[1])) {
                    $handle->setHeaders([trim($parts[0]) => trim($parts[1])]);
                }
            }
        }
    }
}