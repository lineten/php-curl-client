<?php


namespace CurlClient\Response;


use Nova\Api\Constants\ContentType;
use Nova\Api\Exceptions\WebRequestException;
use CurlClient\CurlResponse;
use Json;
use Psr\Http\Message\ResponseInterface;

class JsonResponse
{
    protected $json;

    public function __construct(CurlResponse $res)
    {
        $contentType = $res->getHeaderLine('Content-Type');

        if (strpos($contentType, ContentType::APPLICATION_JSON) !== 0) {
            throw (new WebRequestException('Invalid json response Content-Type "' . $contentType . '"', 9999))
                ->setDebugData($res->getDebugInfo());
        }

        $this->json = Json::parse($res->getBody()->__toString());
    }

    public function getJson()
    {
        return $this->json;
    }
}