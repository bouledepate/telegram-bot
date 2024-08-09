<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Redis;

use Redis;
use RedisException;

/** @extends Redis */
final readonly class RedisConnection implements RedisConnectionInterface
{
    public function __construct(protected Redis $redis)
    {
    }

    /** @throws RedisException */
    final public function selectDatabase(int $index): void
    {
        $this->redis->select($index);
    }

    final public function getConnection(): Redis
    {
        return $this->redis;
    }

    /** @throws RedisException */
    final public function closeConnection(): void
    {
        $this->redis->close();
    }

    /** @throws RedisUnavailable */
    public function __call(string $name, array $arguments)
    {
        try {
            return $this->$name(...$arguments);
        } catch (RedisException) {
            throw new RedisUnavailable();
        }
    }
}