<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Redis;

use Redis;

interface RedisConnectionInterface
{
    public function getConnection(): Redis;
    public function closeConnection(): void;
    public function selectDatabase(int $index): void;
}