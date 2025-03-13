<?php

namespace NativeSupport\PHPRedis\Connector;

use NativeSupport\PHPRedis\Config\RedisLabConfig;
use NativeSupport\PHPRedis\Config\RedisStandaloneConfig;
use NativeSupport\PHPRedis\Enum\ErrorMessages;
use NativeSupport\PHPRedis\Connector\Contract;

class RedisStandaloneConnector implements Contract
{
    private RedisStandaloneConfig $config;

    public function __construct(RedisStandaloneConfig $config)
    {
        $this->config = $config;
    }

    public function connect(\Redis $redis): bool
    {
        try {
            if ($redis->connect($this->config->host, $this->config->port, $this->config->timeout)) {
                if ($this->config->auth) {
                    $redis->auth($this->config->auth);
                }
                return true;
            }
        } catch (\Exception $e) {
            throw new \Exception(ErrorMessages::CONNECTION_ERROR->value . $e->getMessage());
        }
        return false;
    }
}
