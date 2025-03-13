<?php

namespace NativeSupport\PHPRedis\Config;

class RedisLabConfig
{
    public function __construct(public string $host,
                                public int $port,
                                public int $timeout,
                                public string $auth)
    {
    }
}
