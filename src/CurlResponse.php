<?php


namespace TH\CurlClient;

use Slim\Psr7\Response;
use TH\CurlClient\Exception\CurlClientException;

/**
 * Class CurlResponse
 * @package CurlClient
 */
class CurlResponse extends Response
{
    protected $info = [];
    protected $errors = [];

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        $statusCode = $this->getStatusCode();
        return empty($this->errors) && $statusCode > 0 && $statusCode < 300;
    }

    /**
     * @param $code
     * @param $message
     * @return static
     */
    public function withError($code, $message)
    {
        $clone = clone $this;
        $clone->errors[$code] = $message;
        return $clone;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return !empty($this->errors);
    }

    /**
     * @return $this
     * @throws CurlClientException
     */
    public function throwExceptionOnError()
    {
        foreach ($this->errors as $code => $message) {
            throw new CurlClientException($message, $code);
        }
        return $this;
    }

    /**
     * @param $info
     * @return static
     */
    public function withInfo($info)
    {
        $clone = clone $this;
        $clone->info = $info;
        return $clone;
    }

    /**
     * @return array
     */
    public function getInfo(): array
    {
        return $this->info;
    }

    /**
     * @return array
     */
    public function getDebugInfo()
    {
        return [
            'info' => $this->info,
            'errors' => $this->errors,
            'headers' => $this->getHeaders(),
            'body' => $this->getBody()->__toString(),
        ];
    }
}
