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
     * @return CurlRequest
     */
    public function with(callable $callback): self
    {
        $this->setup[] = $callback;
        return $this;
    }

    /**
     * @param array $options
     * @return CurlRequest
     */
    public function withOptions(array $options): self
    {
        return $this->with(new Options($options));
    }

    /**
     * @param string $name
     * @param string $value
     * @return CurlRequest
     */
    public function withHeader(string $name, string $value): self
    {
        return $this->with(new Headers([$name . ': ' . $value]));
    }

    /**
     * @param $headers
     * @return CurlRequest
     */
    public function withHeaders($headers): self
    {
        return $this->with(new Headers($headers));
    }

    /**
     * @param $data
     * @return CurlRequest
     */
    public function withJson($data): self
    {
        return $this->with(new Json($data));
    }

    /**
     * @param string $username
     * @param string $password
     * @return CurlRequest
     */
    public function withBasicAuth(string $username, string $password): self
    {
        return $this->with(new Options([CURLOPT_USERPWD => $username . ":" . $password]));
    }

    /**
     * @param string $data
     * @return CurlRequest
     */
    public function withXml(string $data): self
    {
        return $this->with(new Xml($data));
    }

    /**
     * @param string $request
     * @return CurlRequest
     */
    public function withSoap(string $request): self
    {
        return $this->with(new Soap($request));
    }

    /**
     * @param string $data
     * @return CurlRequest
     */
    public function withBody(string $data): self
    {
        return $this->with(new BodyContent($data));
    }

    /**
     * @param $data
     * @return CurlRequest
     */
    public function withForm($data): self
    {
        return $this->with(new FormData($data));
    }

    /**
     * @param array $params
     * @return CurlRequest
     */
    public function withQueryParams(array $params): self
    {
        return $this->with(new QueryParams($params));
    }

    /**
     * @param integer $seconds
     * @return CurlRequest
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
