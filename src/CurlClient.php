<?php


namespace CurlClient;


use CurlClient\Request\DefaultOptions;
use CurlClient\Request\Options;
use CurlClient\Request\Request;
use CurlClient\Request\ValidateMethod;
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
    public static function request()
    {
        return (new CurlRequest(new CurlHandle()))->with(new DefaultOptions())->with(new ValidateMethod());
    }

    /**
     * @param $method
     * @param $url
     * @return CurlRequest
     */
    public static function build(string $method, string $url)
    {
        return self::request()->with(new Request($method, $url));
    }

    /**
     * @param $url
     * @return CurlRequest
     */
    public static function post($url)
    {
        return self::build('POST', $url);
    }

    /**
     * @param $url
     * @return CurlRequest
     */
    public static function get($url)
    {
        return self::build('GET', $url);
    }

    /**
     * @param $url
     * @return CurlRequest
     */
    public static function put($url)
    {
        return self::build('PUT', $url);
    }

    /**
     * @param $url
     * @return CurlRequest
     */
    public static function delete($url)
    {
        return self::build('DELETE', $url);
    }
}