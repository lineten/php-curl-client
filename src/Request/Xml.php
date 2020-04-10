<?php


namespace TH\CurlClient\Request;

use TH\Constants\ContentType;
use TH\Constants\HttpRequestHeader;
use TH\CurlClient\CurlHandle;

class Xml
{
    public $data;

    /**
     * Json constructor.
     * @param $data
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
        $handle->setBody($this->data);
        $handle->setHeaders([
            HttpRequestHeader::CONTENT_TYPE => ContentType::TEXT_XML
        ]);
    }
}
