Example usage:

```php
<?php

use TH\Constants\HttpRequestHeader;
use TH\CurlClient\CurlClient;
use TH\CurlClient\CurlMulti;
use TH\CurlClient\CurlResponse;
use TH\CurlClient\Request\Authorization;
use TH\CurlClient\Request\Headers;
use TH\CurlClient\Request\Json;
use TH\CurlClient\Request\QueryParams;

// Sync request
$response = CurlClient::post('https://example.com')
    ->with(new Json(['key'=>'value']))
    ->with(new QueryParams(['test' => 1]))
    ->with(new Authorization('Bearer: abc'))
    ->with(new Headers(['X-Test: test']))
    ->send();

$status = $response->getStatusCode();
$contentType = $response->getHeaderLine(HttpRequestHeader::CONTENT_TYPE);
$body = $response->getBody()->__toString();

var_dump($status, $contentType, $body);


// Async request
$request = CurlClient::get('https://google.com')
    ->with(new Json(['key'=>'value']))
    ->with(new QueryParams(['test' => 1]))
    ->with(new Authorization('Bearer: abc'));

$multi = new CurlMulti;
$multi->add($request, function(CurlResponse $response){
    $status = $response->getStatusCode();
    $contentType = $response->getHeaderLine(HttpRequestHeader::CONTENT_TYPE);
    $body = $response->getBody()->__toString();
    
    var_dump($status, $contentType, $body);
});
$multi->send();


// Use built-in helper functions
$response = CurlClient::post('https://example.com')
    ->withJson(['key'=>'value'])
    ->withQueryParams(['test' => 1])
    ->send();
```
