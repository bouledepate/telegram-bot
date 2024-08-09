<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Redis;

use BDP\Kernel\Components\Redis\Traits\RedisHashTrait;
use Redis;
use RedisException;

abstract class RedisRepository
{
    use RedisHashTrait;

    public function __construct(private readonly RedisConnectionInterface $redisConnection)
    {
        $this->redisConnection->selectDatabase(index: $this->getDatabase());
    }

    final public function getKey(string $key): string
    {
        return $this->prefix() . $key;
    }

    final public function getConnection(): Redis
    {
        return $this->redisConnection->getConnection();
    }

    /** @throws RedisException */
    public function setExpire(string $key, int $ttl): bool
    {
        return $this->getConnection()->expire($this->getKey($key), $ttl);
    }

    protected function getDatabase(): int
    {
        return 0;
    }

    protected function prefix(): string
    {
        return 'apollo:';
    }

    /** @throws RedisException */
    public function delete(string $key): bool
    {
        return $this->getConnection()->del($this->getKey($key)) > 0;
    }

    public function __call(string $name, array $arguments)
    {
        try {
            return $this->$name(...$arguments);
        } finally {
            $this->redisConnection->closeConnection();
        }
    }
}