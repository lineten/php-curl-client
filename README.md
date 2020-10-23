**Problems solved:**
1. Guzzle is huge and complicated.
2. As functionality is added, the files become larger for everyone.

**Solutions:**
1. Custom cURL abstraction.
2. Classes don't grow, instead new classes are added for each new bit of functionality.

Follows PSR-7

Example usage:

```php
<?php
require 'vendor/autoload.php';
header('Content-Type: text/plain;charset=utf-8');

use Lineten\CurlClient\Constant\ContentType;
use Lineten\CurlClient\Constant\HttpRequestHeader;
use Lineten\CurlClient\CurlMulti;
use Lineten\CurlClient\CurlClient;
use Lineten\CurlClient\CurlResponse;
use Lineten\CurlClient\Request\Authorization;
use Lineten\CurlClient\Request\Headers;
use Lineten\CurlClient\Request\Json;
use Lineten\CurlClient\Request\QueryParams;

// Sync request
echo 'Sync request'.PHP_EOL;
echo '================================='.PHP_EOL;
$response = CurlClient::post('https://example.com')
    ->with(new Json(['key'=>'value']))
    ->with(new QueryParams(['test' => 1]))
    ->with(new Authorization('Bearer: abc'))
    ->with(new Headers(['X-Test: test']))
    ->send();

$status = $response->getStatusCode();
$body = $response->getBody()->__toString();

echo 'StatusCode: '.$status.PHP_EOL;
foreach($response->getHeaders() as $name => $headers) {
    foreach($headers as $value){
        echo $name.': '.$value.PHP_EOL;
    }
}
echo PHP_EOL.$body.PHP_EOL;


// Async request
echo PHP_EOL;
echo PHP_EOL;
echo 'Async request'.PHP_EOL;
echo '================================='.PHP_EOL;
$request = CurlClient::get('https://google.com')
    ->with(new Json(['key'=>'value']))
    ->with(new QueryParams(['test' => 1]))
    ->with(new Authorization('Bearer: abc'));

$multi = new CurlMulti;
$multi = $multi->add($request, function(CurlResponse $response){
    $status = $response->getStatusCode();
    $body = $response->getBody()->__toString();
    
    echo 'StatusCode: '.$status.PHP_EOL;
    foreach($response->getHeaders() as $name => $headers) {
        foreach($headers as $value){
            echo $name.': '.$value.PHP_EOL;
        }
    }
    echo PHP_EOL.$body.PHP_EOL;
});
$multi->send();


// Use built-in helper functions
$response = CurlClient::post('https://example.com')
    ->withJson(['key'=>'value'])
    ->withQueryParams(['test' => 1]);

// Call it as an instance
$client = new CurlClient;
$request = $client->post('https://example.com');
$request = $request->with(new Authorization('Bearer: abc'));

/** @var CurlResponse $response PSR-7 Response with extra methods that are specific to curl */ 
$response = $request->send(); 
```

