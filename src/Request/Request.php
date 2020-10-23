<?php


namespace Lineten\CurlClient\Request;


use Lineten\CurlClient\CurlHandle;

/**
 * Class Request
 * @package Lineten\CurlClient\Request
 */
class Request
{
    public $url;
    public $method;

    /**
     * Request constructor.
     * @param string $method
     * @param string $url
     */
    public function __construct(string $method, string $url)
    {
        $this->url = $url;
        $this->method = $method;
    }

    /**
     * @param CurlHandle $handle
     */
    public function __invoke(CurlHandle $handle)
    {
        $handle->setOptions([
            CURLOPT_URL => $this->url,
            CURLOPT_CUSTOMREQUEST => strtoupper($this->method),
        ]);
    }
}
