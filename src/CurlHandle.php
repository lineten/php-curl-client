<?php


namespace TH\CurlClient;

use Psr\Http\Message\StreamInterface;
use Slim\Psr7\Stream;
use TH\CurlClient\Exception\CurlClientException;

/**
 * A mutable CURL wrapper to simplify CURL usage due to the lack of documentation.
 * exec() is separate from getResponse() because this handle might be executed by CurlMulti
 *
 * $ch = new CurlHandle;
 * $ch->setHeaders(['X-Test' => 1]);
 * $ch->exec();
 * $res = $ch->getResponse();
 * if ($res->getStatusCode() === 200) {
 *     $body = $res->getBody()->__toString();
 * }
 *
 * Class CurlHandle
 * @package CurlClient2
 */
class CurlHandle
{
    protected $options = [];
    protected $requestHeaders = [];
    protected $requestBody;
    public $ch;
    public $errors = [];
    public $info = [];
    public $responseCode = 0;
    public $responseHeaders = [];
    public $responseBody;

    public function __construct()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_WRITEFUNCTION, [$this, 'writeBody']);
        curl_setopt($this->ch, CURLOPT_HEADERFUNCTION, [$this, 'writeHeader']);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }

    /**
     * @param callable $callback
     */
    public function with(callable $callback)
    {
        call_user_func($callback, $this);
    }

    /**
     * @param $code
     * @param string $message
     */
    public function writeError($code, string $message)
    {
        $this->errors[$code] = $message;
    }

    /**
     * @param $ch
     * @param string $header
     * @return int
     */
    public function writeHeader($ch, $header)
    {
        // This is the protocol and status header
        if ($this->responseHeaders === []) {
            $this->responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        }

        $parts = explode(':', $header, 2);

        // ignore invalid headers
        if (!isset($parts[1]) || trim($parts[0]) === '') {
            return strlen($header);
        }
        $this->responseHeaders[trim(strtolower($parts[0]))] = trim($parts[1]);

        return strlen($header);
    }

    /**
     * @param $ch
     * @param string $str
     * @return int
     */
    public function writeBody($ch, $str)
    {
        $this->responseBody = $this->responseBody ?? new Stream(fopen('php://temp', 'rw+'));
        return $this->responseBody->write($str);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = array_replace($this->options, $options);
        curl_setopt_array($this->ch, $this->options);
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->requestHeaders;
    }

    /**
     * @param array $requestHeaders
     */
    public function setHeaders(array $requestHeaders)
    {
        foreach ($requestHeaders as $name => $value) {
            $key = strtolower($name);
            if ($value === null) {
                unset($this->requestHeaders[$key]);
            }
            $this->requestHeaders[$key] = $name . ': ' . $value;
        }
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array_values($this->requestHeaders));
    }

    /**
     * @param string $str
     */
    public function setBody(string $str)
    {
        // Passing an array to CURLOPT_POSTFIELDS will encode the data as multipart/form-data,
        // while passing a URL-encoded string will encode the data as application/x-www-form-urlencoded.
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $str);
        $this->setHeaders(['Content-Length' => strlen($str)]);
    }

    /**
     * @throws CurlClientException Error fetching external resource
     */
    public function exec()
    {
        if (curl_exec($this->ch) === false) {
            throw new CurlClientException(curl_error($this->ch), curl_errno($this->ch));
        }
        $this->info = curl_getinfo($this->ch);
    }

    /**
     * @return CurlResponse
     */
    public function getResponse()
    {
        $res = new CurlResponse();

        if (curl_errno($this->ch) !== 0) {
            $res = $res->withError(curl_errno($this->ch), curl_error($this->ch));
        }

        $res = $res->withInfo($this->info);

        if (!$res->hasError() && $this->responseCode > 0) {
            $res = $res->withStatus($this->responseCode);
            if ($this->responseBody instanceof StreamInterface) {
                $body = new Stream(fopen('php://temp', 'rw+'));
                $body->write($this->responseBody->__toString());
                $res = $res->withBody($body);
            }
        }

        foreach ($this->responseHeaders as $name => $value) {
            /** @var CurlResponse $res */
            $res = $res->withHeader($name, $value);
        }

        return $res;
    }
}
