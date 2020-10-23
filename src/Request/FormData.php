<?php


namespace Lineten\CurlClient\Request;


use Lineten\CurlClient\Constant\ContentType;
use Lineten\CurlClient\Constant\HttpRequestHeader;
use Lineten\CurlClient\CurlHandle;

class FormData
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __invoke(CurlHandle $handle)
    {
        $handle->setBody(http_build_query($this->data));
        $handle->setHeaders([
            HttpRequestHeader::CONTENT_TYPE => ContentType::APPLICATION_FORM_URLENCODED,
        ]);
    }
}
