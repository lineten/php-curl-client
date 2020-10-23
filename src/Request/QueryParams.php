<?php


namespace Lineten\CurlClient\Request;


use Lineten\CurlClient\CurlHandle;

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
        $url = self::modifyQuery($url, $this->params);
        $handle->setOptions([
            CURLOPT_URL => $url
        ]);
    }

    private static function modifyQuery(string $url, array $params): string
    {
        $path = $url;
        $queryParams = [];
        if (strpos($url, '?') !== false) {
            list($path, $queryString) = explode('?', $url, 2);
            parse_str($queryString, $queryParams);
        }

        // Replace existing keys
        $queryParams = array_replace($queryParams, $params);

        // Remove any keys with null values
        $queryParams = array_filter($queryParams, function ($v) {
            return isset($v);
        });

        // Build the query string like http_build_str would
        $query = [];
        foreach ($queryParams as $k => $v) {
            $query[] = rawurlencode($k) . '=' . rawurlencode($v);
        }

        return $path . ($query ? '?' . implode('&', $query) : '');
    }
}
