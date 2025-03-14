<?php

namespace NativeSupport\PHPRedis;

use Exception;
use NativeSupport\PHPRedis\ErrorMessages;
use NativeSupport\PHPRedis\Connector\Contract;

class RedisClient
{
    private \Redis $redis;
    private Contract $connector;

    /**
     * @param Contract $connector
     * @throws Exception
     */
    public function __construct(Contract $connector)
    {
        $this->redis = new \Redis();
        $this->connector = $connector;
        $this->connect();
    }

    /**
     * @throws Exception
     */
    private function connect(): void
    {
        try {
            if (!$this->connector->connect($this->redis)) {
                throw new Exception(ErrorMessages::CONNECTION_FAILED->value);
            }
        } catch (Exception $e) {
            throw new Exception(ErrorMessages::CONNECTION_ERROR->value . $e->getMessage());
        }
    }

    /**
     * @return \Redis
     */
    public function getRedis(): \Redis
    {
        return $this->redis;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return bool
     * @throws Exception
     */
    public function set(string $key, mixed $value, int $ttl = 0): bool
    {
        try {
            return $ttl > 0 ? $this->redis->setex($key, $ttl, $value) : $this->redis->set($key, $value);
        } catch (Exception $e) {
            throw new Exception(sprintf(ErrorMessages::SET_FAILED->value, $key) . $e->getMessage());
        }
    }

    /**
     * @param string $key
     * @return mixed
     * @throws Exception
     */
    public function get(string $key): mixed
    {
        try {
            return $this->redis->get($key);
        } catch (Exception $e) {
            throw new Exception(sprintf(ErrorMessages::GET_FAILED->value, $key) . $e->getMessage());
        }
    }

    /**
     * @param string $key
     * @return int
     * @throws Exception
     */
    public function incr(string $key): int
    {
        try {
            return $this->redis->incr($key);
        } catch (Exception $e) {
            throw new Exception(sprintf(ErrorMessages::INCR_FAILED->value, $key) . $e->getMessage());
        }
    }

    /**
     * @param string ...$keys
     * @return int
     * @throws Exception
     */
    public function del(string ...$keys): int
    {
        try {
            return $this->redis->del($keys);
        } catch (Exception $e) {
            throw new Exception(sprintf(ErrorMessages::DEL_FAILED->value, implode(', ', $keys)) . $e->getMessage());
        }
    }

    /**
     * @param string $index
     * @param string $query
     * @param array $options
     * @return array|bool
     * @throws Exception
     */
    public function search(string $index, string $query, array $options = []): array|bool
    {
        try {
            $args = [$index, $query];
            foreach ($options as $key => $value) {
                $args[] = strtoupper($key);
                if (!is_bool($value)) {
                    $args[] = $value;
                }
            }
            return $this->redis->rawCommand('FT.SEARCH', ...$args);
        } catch (Exception $e) {
            throw new Exception(sprintf(ErrorMessages::SEARCH_FAILED->value, $index) . $e->getMessage());
        }
    }

    /**
     * @param callable $callback
     * @return array
     * @throws Exception
     */
    public function pipeline(callable $callback): array
    {
        try {
            $pipeline = $this->redis->multi(\Redis::PIPELINE);
            $callback($pipeline);
            return $pipeline->exec();
        } catch (Exception $e) {
            throw new Exception(ErrorMessages::PIPELINE_FAILED->value . $e->getMessage());
        }
    }

    public function hset(string $key, string $field, mixed $value): bool
    {
        try {
            return $this->redis->hSet($key, $field, $value);
        } catch (\Exception $e) {
            throw new \Exception(sprintf(ErrorMessages::HSET_FAILED->value, $key) . $e->getMessage());
        }
    }

    public function hmget(string $key, array $fields): array
    {
        try {
            return $this->redis->hMGet($key, $fields);
        } catch (\Exception $e) {
            throw new \Exception(sprintf(ErrorMessages::HMGET_FAILED->value, $key) . $e->getMessage());
        }
    }

    public function hgetall(string $key): array
    {
        try {
            return $this->redis->hGetAll($key);
        } catch (\Exception $e) {
            throw new \Exception(sprintf(ErrorMessages::HGETALL_FAILED->value, $key) . $e->getMessage());
        }
    }
}
