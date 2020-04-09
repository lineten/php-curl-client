<?php


namespace CurlClient\Request;


use Nova\Api\Constants\ContentType;
use CurlClient\CurlHandle;

class Json
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __invoke(CurlHandle $handle)
    {
        $handle->setBody(\Json::stringify($this->data));
        $handle->setHeaders(['Content-Type' => ContentType::APPLICATION_JSON]);
    }
}