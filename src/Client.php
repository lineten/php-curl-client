<?php

namespace Lineten\CurlClient;

use Fig\Http\Message\RequestMethodInterface;
use Lineten\CurlClient\Request\Request;
use Lineten\CurlClient\Request\ValidateMethod;

/**
 * Class Client.
 * $c->post()
 */
class Client
{
    /**
     * @return CurlRequest
     */
    public function request()
    {
        return (new CurlRequest())->with(new ValidateMethod());
    }

    /**
     * @param $method
     * @param $url
     * @return CurlRequest
     */
    public function build(string $method, string $url)
    {
        return self::request()->with(new Request($method, $url));
    }

    /**
     * @param $url
     * @return CurlRequest
     */
    public function post($url)
    {
        return self::build(RequestMethodInterface::METHOD_POST, $url);
    }

    /**
     * @param $url
     * @return CurlRequest
     */
    public function get($url)
    {
        return self::build(RequestMethodInterface::METHOD_GET, $url);
    }

    /**
     * @param $url
     * @return CurlRequest
     */
    public function put($url)
    {
        return self::build(RequestMethodInterface::METHOD_PUT, $url);
    }

    /**
     * @param $url
     * @return CurlRequest
     */
    public function delete($url)
    {
        return self::build(RequestMethodInterface::METHOD_DELETE, $url);
    }
}
