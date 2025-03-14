# Native Library for PHPRedis
Supports the following commands for the RedisClient. If you are moving from PRedis to PHPRedis, this package will help you to move in the shortest possible time.

- set
- get
- hset
- hmget
- hmgetall
- pipeline
- search
- dbsize
- lpush
- lpop
- rpush
- rpop

## Documentation

Here is an implementation example:

```php
// Redis Sentinel Implementation
$config = new RedisSentinelConfig(
    [
        'sentinel-1:26379'
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
    'redis-master',
    6379,
    5,
    ""
);
$connector = new RedisStandaloneConnector($config);
$index = "abs:idx";
try {
    $client = new RedisClient($connector);
    $client->pipeline(function ($pipe) {
        $pipe->set('key1', 'value1');
        $pipe->set('key2', 'value2');
    });
    dump($client->get('key2'));
    $result = $client->search(
        $index,
        'FT.',
        []
    );
    dump($result);
    // Hash Example
    $client->hset('user:1001', 'name', 'Alice');
    $client->hset('user:1001', 'age', '30');
    echo json_encode($client->hmget('user:1001', ['name', 'age']));
    echo json_encode($client->hgetall('user:1001'));
    
    // List Example
    $client->lpush('tasks', 'task1', 'task2', 'task3');
    echo $client->lpop('tasks');
    $client->rpush('tasks', 'task4', 'task5');
    echo $client->rpop('tasks');
    
    echo "DB Size: " . $client->dbsize();
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
    $client->search(
        $index,
        'FT.',
        []
    );
} catch (Exception $e) {
    dump($e->getMessage());
}
```

## Check Out
You can run the `docker-compose.yml` with

```bash
docker compose up -d
```

It will spin up 4 containers
- master
- slave-1
- slave-2
- sentinel-1

By this, you can test out the library and confirm.

## How to install

Add this to your `composer.json` file

### package

```json
"require": {
    ...,
  "native-support/php-redis": "^1.0.0",
},
```

### vcs
```json

"repositories":[
        {
            "type": "vcs",
            "url": "https://github.com/ferdousulhaque/native-redis.git"
        }
    ],
```

## Contributor
- A S Md Ferdousul Haque

## License
- GNU
