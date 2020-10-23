<?php


namespace Lineten\CurlClient\Request;


use Lineten\CurlClient\Constant\ContentType;
use Lineten\CurlClient\CurlHandle;

/**
 * Class BodyContent
 * @package Lineten\CurlClient\Request
 */
class BodyContent
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
    }
}
