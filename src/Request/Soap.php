<?php


namespace TH\CurlClient\Request;

use TH\Constants\ContentType;
use TH\Constants\HttpRequestHeader;
use TH\CurlClient\CurlHandle;

class Soap
{
    public $data;

    /**
     * Soap constructor.
     * @param string $data
     */
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * @param CurlHandle $handle
     */
    public function __invoke(CurlHandle $handle)
    {
        $handle->with(new Options([
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => 300,
        ]));
        $handle->setHeaders([
            HttpRequestHeader::CONTENT_TYPE => ContentType::TEXT_XML,
        ]);
        $handle->setBody($this->data);
    }
}
