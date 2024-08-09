<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Redis\Traits;

use Redis;
use RedisException;

trait RedisHashTrait
{
    abstract public function getConnection(): Redis;

    abstract public function getKey(string $key): string;

    /** @throws RedisException */
    public function setHash(string $key, array $data, bool $rewrite = true): bool
    {
        $hash = $this->getKey($key);
        $method = $rewrite ? 'hSet' : 'hSetNx';
        if (count($data) > 1) {
            $transaction = $this->getConnection()->multi();
            foreach ($data as $key => $value) {
                $transaction->$method($hash, $key, $value);
            }
            $result = $transaction->exec();
            $response = count($result) == array_filter($result, fn ($value) => $value == 1);
        } else {
            $dataKey = array_key_first($data);
            $response = $this->getConnection()->$method($hash, $dataKey, $data[$dataKey]);
        }
        return $response;
    }

    /** @throws RedisException */
    public function getHashValue(string $key, string $hashKey): string|false
    {
        return $this->getConnection()->hGet($this->getKey($key), $hashKey);
    }

    /** @throws RedisException */
    public function getHashLength(string $key): int
    {
        return $this->getConnection()->hLen($this->getKey($key));
    }

    /** @throws RedisException */
    public function deleteHashValue(string $key, ?string $hashKey = null): int
    {
        return $this->getConnection()->hDel($this->getKey($key), $hashKey);
    }

    /** @throws RedisException */
    public function hashKeyExists(string $key, string $hashKey): bool
    {
        return $this->getConnection()->hExists($this->getKey($key), $hashKey);
    }

    /** @throws RedisException */
    public function getAllHash(string $key): array
    {
        return $this->getConnection()->hGetAll($this->getKey($key));
    }
}