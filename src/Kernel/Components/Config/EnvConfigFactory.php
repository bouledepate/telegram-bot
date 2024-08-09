<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Config;

use BDP\Kernel\Components\Config\Structure\EnvConfig;
use ReflectionException;

final readonly class EnvConfigFactory
{
    public function __construct(private array $environment = [])
    {
    }

    /** @throws ReflectionException */
    public function produce(ConfigType $type): EnvConfig
    {
        return match ($type) {
            ConfigType::Kernel => KernelConfig::collectFrom($this->environment),
            ConfigType::Database => ConnectionConfig::collectFrom($this->environment),
            ConfigType::Redis => RedisConfig::collectFrom($this->environment),
            ConfigType::Telegram => TelegramConfig::collectFrom($this->environment),
        };
    }
}