<?php


namespace CurlClient;


use CurlClient\Request\Callback;
use CurlClient\Request\FormData;
use CurlClient\Request\Headers;
use CurlClient\Request\Json;
use CurlClient\Request\Options;
use CurlClient\Request\QueryParams;

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
        $clone = clone $this;
        $clone->setup[] = $callback;
        return $clone;
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
        return $this->with(new Headers([$name => $value]));
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
     */
    public function send()
    {
        $handle = $this->getHandle();
        $handle->exec();
        return $handle->getResponse()->throwExceptionOnError();
    }
}