<?php

use NativeSupport\PHPRedis\Config\RedisLabConfig;
use \NativeSupport\PHPRedis\Config\RedisSentinelConfig;
use NativeSupport\PHPRedis\Config\RedisStandaloneConfig;
use NativeSupport\PHPRedis\Connector\RedisLabConnector;
use NativeSupport\PHPRedis\Connector\RedisSentinelConnector;
use NativeSupport\PHPRedis\Connector\RedisStandaloneConnector;
use NativeSupport\PHPRedis\RedisClient;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
*/

require __DIR__.'/vendor/autoload.php';

// Redis Sentinel Implementation
$config = new RedisSentinelConfig(
    [
        '127.0.0.1:26379'
    ], 200, 'mymaster'
);
$connector = new RedisSentinelConnector($config);
try {
    $key = "testing";
    $client = new RedisClient($connector);
    $client->set($key, 200);
    $client->incr($key);
    dump($client->get($key));
} catch (Exception $e) {
    dump($e->getMessage());
}

// RediSearch Implementation
$config = new RedisStandaloneConfig(
    '127.0.0.1',
    6379,
    5,
    ""
);
$connector = new RedisStandaloneConnector($config);
$index = "abs:idx";
try {
    $client = new RedisClient($connector);
    $client->search(
        $index,
        'FT.',
        []
    );
} catch (Exception $e) {
    dump($e->getMessage());
}

// RedisLab Implementation
$config = new RedisLabConfig(
    '127.0.0.1',
    6379,
    5,
    ""
);
$connector = new RedisLabConnector($config);
try {
    $key = "testing";
    $client = new RedisClient($connector);
    $client->set($key, 200);
    $client->incr($key);
    dump($client->get($key));
} catch (Exception $e) {
    dump($e->getMessage());
}
