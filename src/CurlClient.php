<?php


namespace TH\CurlClient;

use Fig\Http\Message\RequestMethodInterface;
use TH\CurlClient\Request\DefaultOptions;
use TH\CurlClient\Request\Options;
use TH\CurlClient\Request\Request;
use TH\CurlClient\Request\ValidateMethod;
use Psr\Http\Message\RequestInterface;

/**
 * Class CurlClient
 * @package CurlClient2
 *
 *
 * $c->post()
 *
 */
class CurlClient
{
    /**
     * @return CurlRequest
     */
    public function request()
    {
        return (new CurlRequest(new CurlHandle()))->with(new DefaultOptions())->with(new ValidateMethod());
    }

    /**
     * @param $method
     * @param $url
     * @return CurlRequest
     */
    public function build(string $method, string $url)
    {
        return $this->request()->with(new Request($method, $url));
    }

    /**
     * @param $url
     * @return CurlRequest
     */
    public function post($url)
    {
        return $this->build(RequestMethodInterface::METHOD_POST, $url);
    }

    /**
     * @param $url
     * @return CurlRequest
     */
    public function get($url)
    {
        return $this->build(RequestMethodInterface::METHOD_GET, $url);
    }

    /**
     * @param $url
     * @return CurlRequest
     */
    public function put($url)
    {
        return $this->build(RequestMethodInterface::METHOD_PUT, $url);
    }

    /**
     * @param $url
     * @return CurlRequest
     */
    public function delete($url)
    {
        return $this->build(RequestMethodInterface::METHOD_DELETE, $url);
    }
}
