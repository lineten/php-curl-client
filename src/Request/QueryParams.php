<?php


namespace TH\CurlClient\Request;


use TH\CurlClient\CurlHandle;
use TH\Url\Url;

class QueryParams
{
    public $params = [];

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function __invoke(CurlHandle $handle)
    {
        $options = $handle->getOptions();
        $url = $options[CURLOPT_URL];
        $url = Url::modifyQuery($url, $this->params);
        $handle->setOptions([
            CURLOPT_URL => $url
        ]);
    }
}
