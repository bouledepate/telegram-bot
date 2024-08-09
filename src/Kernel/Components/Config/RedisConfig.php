<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Config;

use BDP\Kernel\Components\Config\Structure\AbstractEnvConfig;
use BDP\Kernel\Components\Environment\Constant;

final readonly class RedisConfig extends AbstractEnvConfig
{
    private string $host;
    private int $port;
    private string $user;
    private string $password;

    protected function constantMap(): array
    {
        return [
            'host' => Constant::REDIS_HOST,
            'port' => Constant::REDIS_PORT,
            'user' => Constant::REDIS_USER,
            'password' => Constant::REDIS_PASSWORD,
        ];
    }
}