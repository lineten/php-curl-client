<?php


namespace Lineten\CurlClient\Request;

use Lineten\CurlClient\Constant\HttpRequestHeader;
use Lineten\CurlClient\Constant\ContentType;
use Lineten\CurlClient\CurlHandle;

/**
 * Class Xml
 * @package Lineten\CurlClient\Request
 */
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
        $handle->setHeaders([HttpRequestHeader::CONTENT_TYPE => ContentType::TEXT_XML]);
    }
}
