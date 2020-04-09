<?php


namespace CurlClient\Request;

use CurlClient\CurlHandle;
use Globals;

class RateLimit
{
    public $rateName;
    public $limit;
    public $window;
    public $sleep;

    public function __construct(string $name, int $limit = 10, int $window = 10, int $sleep = 1000000)
    {
        $this->rateName = $name;
        $this->limit = $limit;
        $this->window = $window;
        $this->sleep = $sleep;
    }

    public function __invoke(CurlHandle $handle)
    {
        // Throttle requests with sleep if rate limit reached, 10 and 10 should be good values
        if ($this->rateName && Globals::$redisClient->rateLimit($this->rateName, $this->limit, $this->window) === 0) {
            usleep(1000000);
        }
    }
}