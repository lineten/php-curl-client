<?php declare(strict_types=1);

namespace Lineten\CurlClient;

use PHPUnit\Framework\TestCase;
use Lineten\CurlClient\Exception\CurlClientException;

final class CurlClientTest extends TestCase
{
    public function testGet(): void
    {
        $cc = new Client;
        $res = $cc->get('https://www.cloudflare.com/')->send();
        self::assertSame(200, $res->getStatusCode(), $res->getBody()->__toString());
        self::assertNotEmpty($res->getBody()->__toString());
    }

    public function testInvalidDomain(): void
    {
        $this->expectException(CurlClientException::class);

        $cc = new Client;
        $res = $cc->get('https://host.invalid')->send();
        self::assertSame(404, $res->getStatusCode(), $res->getBody()->__toString());
    }

    public function testGetNotFound(): void
    {
        $cc = new Client;
        $res = $cc->get('http://google.com/notfound-')->send();
        self::assertSame(404, $res->getStatusCode(), $res->getBody()->__toString());
    }
}
