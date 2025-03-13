<?php

namespace NativeSupport\PHPRedis\Connector;

use NativeSupport\PHPRedis\Config\RedisSentinelConfig;
use NativeSupport\PHPRedis\Connector\Contract;

class RedisSentinelConnector implements Contract
{
    private RedisSentinelConfig $config;

    public function __construct(RedisSentinelConfig $config)
    {
        $this->config = $config;
    }

    public function connect(\Redis $redis): bool
    {
        foreach ($this->config->sentinels as $sentinel) {
            [$host, $port] = explode(':', $sentinel);
            try {
                $sentinelRedis = new \Redis();
                if ($sentinelRedis->connect($host, (int)$port, $this->config->timeout)) {
                    $master = $sentinelRedis->rawCommand('SENTINEL', 'get-master-addr-by-name', $this->config->masterName);
                    if ($master && is_array($master)) {
                        [$masterHost, $masterPort] = $master;
                        return $redis->connect($masterHost, (int)$masterPort, $this->config->timeout);
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        return false;
    }
}
