<?php

namespace NativeSupport\PHPRedis\Config;

class RedisSentinelConfig
{
    public function __construct(public array $sentinels,
                                public int $timeout,
                                public string $masterName)
    {
    }
}
