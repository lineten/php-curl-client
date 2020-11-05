<?php


namespace Lineten\CurlClient;


use Lineten\CurlClient\Request\BodyContent;
use Lineten\CurlClient\Request\Callback;
use Lineten\CurlClient\Request\FormData;
use Lineten\CurlClient\Request\Headers;
use Lineten\CurlClient\Request\Json;
use Lineten\CurlClient\Request\Options;
use Lineten\CurlClient\Request\QueryParams;
use Lineten\CurlClient\Request\Soap;
use Lineten\CurlClient\Request\Xml;

class CurlRequest
{
    /** @var callable[] $setup */
    protected $setup = [];

    /**
     * @param callable $callback
     * @return static
     */
    public function with(callable $callback)
    {
        $this->setup[] = $callback;
        return $this;
    }

    /**
     * @param array $options
     * @return static
     */
    public function withOptions(array $options)
    {
        return $this->with(new Options($options));
    }

    /**
     * @param string $name
     * @param string $value
     * @return static
     */
    public function withHeader(string $name, string $value)
    {
        return $this->with(new Headers([$name . ': ' . $value]));
    }

    /**
     * @param $headers
     * @return static
     */
    public function withHeaders($headers)
    {
        return $this->with(new Headers($headers));
    }

    /**
     * @param $data
     * @return static
     */
    public function withJson($data)
    {
        return $this->with(new Json($data));
    }

    /**
     * @param string $username
     * @param string $password
     * @return static
     */
    public function withBasicAuth(string $username, string $password)
    {
        return $this->with(new Options([CURLOPT_USERPWD => $username . ":" . $password]));
    }

    /**
     * @param string $data
     * @return static
     */
    public function withXml(string $data)
    {
        return $this->with(new Xml($data));
    }

    /**
     * @param string $request
     * @return static
     */
    public function withSoap(string $request)
    {
        return $this->with(new Soap($request));
    }

    /**
     * @param string $data
     * @return static
     */
    public function withBody(string $data)
    {
        return $this->with(new BodyContent($data));
    }

    /**
     * @param $data
     * @return static
     */
    public function withForm($data)
    {
        return $this->with(new FormData($data));
    }

    /**
     * @param array $params
     * @return static
     */
    public function withQueryParams(array $params)
    {
        return $this->with(new QueryParams($params));
    }

    /**
     * @param integer $seconds
     * @return static
     */
    public function withTimeout(int $seconds)
    {
        return $this->with(new Options([
            CURLOPT_TIMEOUT => $seconds,
        ]));
    }

    /**
     * @return CurlHandle
     */
    public function getHandle()
    {
        $handle = new CurlHandle();
        foreach ($this->setup as $setupCallback) {
            $setupCallback($handle);
        }
        return $handle;
    }

    /**
     * @return CurlResponse
     * @throws Exception\CurlClientException
     */
    public function send()
    {
        $handle = $this->getHandle();
        $handle->exec();
        return $handle->getResponse()->throwExceptionOnError();
    }
}
