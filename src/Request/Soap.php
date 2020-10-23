<?php


namespace Lineten\CurlClient\Request;

use Lineten\CurlClient\Constant\HttpRequestHeader;
use Lineten\CurlClient\Constant\ContentType;
use Lineten\CurlClient\CurlHandle;

/**
 * Class Soap
 * @package Lineten\CurlClient\Request
 */
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
        ]));
        $handle->setHeaders([HttpRequestHeader::CONTENT_TYPE => ContentType::TEXT_XML]);
        $handle->setBody($this->data);
    }
}
