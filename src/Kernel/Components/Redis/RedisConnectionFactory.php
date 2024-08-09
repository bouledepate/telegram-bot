<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Redis;

use BDP\Kernel\Components\Config\RedisConfig;
use BDP\Kernel\Components\Environment\Constant;
use Redis;

final readonly class RedisConnectionFactory
{
    public function __construct(private RedisConfig $configuration)
    {
    }

    public function establish(): RedisConnectionInterface
    {
        return new RedisConnection(new Redis(options: [
            'host' => $this->configuration->getValue(Constant::REDIS_HOST),
            'port' => $this->configuration->getValue(Constant::REDIS_PORT),
            'connectTimeout' => 3,
            'auth' => [
                $this->configuration->getValue(Constant::REDIS_USER),
                $this->configuration->getValue(Constant::REDIS_PASSWORD),
            ]
        ]));
    }
}