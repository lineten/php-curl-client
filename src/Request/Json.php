<?php

namespace TH\CurlClient\Request;

use TH\Constants\ContentType;
use TH\Constants\HttpRequestHeader;
use TH\CurlClient\CurlHandle;

class Json
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __invoke(CurlHandle $handle)
    {
        $handle->setBody(json_encode($this->data));
        $handle->setHeaders([
            HttpRequestHeader::CONTENT_TYPE => ContentType::APPLICATION_JSON,
        ]);
    }
}
