<?php


namespace CurlClient\Request;


use Nova\Api\Constants\ContentType;
use CurlClient\CurlHandle;

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
        $handle->setHeaders(['Content-Type' => ContentType::APPLICATION_FORM_URLENCODED]);
    }
}