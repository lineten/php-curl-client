<?php


namespace Lineten\CurlClient;

use Lineten\CurlClient\Constant\ContentType;
use Lineten\CurlClient\Constant\HttpRequestHeader;
use Lineten\CurlClient\Exception\ContentException;
use Slim\Psr7\Response;
use Lineten\CurlClient\Exception\CurlClientException;

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
     * @param int $code
     * @param string $reasonPhrase
     * @return static
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        if ($reasonPhrase === '' && !isset(static::$messages[$code])) {
            $reasonPhrase = 'Non standard error code';
        }
        return parent::withStatus($code, $reasonPhrase);
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

    /**
     * @return string
     */
    public function getBodyString()
    {
        return $this->getBody()->__toString();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getParsedBody()
    {
        $contentType = $this->getContentType();
        if (in_array($contentType, [ContentType::APPLICATION_JSON, 'application/problem+json'])) {
            return json_decode($this->getBody()->__toString(), true);
        }
        if (ContentType::APPLICATION_FORM_URLENCODED === $contentType) {
            parse_str($this->getBody()->__toString(), $data);
            return $data;
        }
        throw new ContentException('Unknown content type "' .  $contentType . '"');
    }
    
    /**
     * Get the content type
     * @return string
     */
    public function getContentType(): string
    {
        $headers = $this->getHeader(HttpRequestHeader::CONTENT_TYPE);
        $header = array_pop($headers);
        list($contentType) = explode(';', $header, 2);
        return trim($contentType);
    }

    /**
     * @param boolean $assoc
     * @return mixed
     */
    public function getJson(bool $assoc = true)
    {
        $json = json_decode($this->getBody()->__toString(), $assoc);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new ContentException('JSON Error: "' . json_last_error_msg() . '"');
        }

        return $json;
    }
}
