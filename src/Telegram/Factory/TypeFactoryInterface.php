<?php

declare(strict_types=1);

namespace BDP\Telegram\Factory;

use BDP\Telegram\Type\TelegramType;

interface TypeFactoryInterface
{
    public function produce(string $class, array $data): TelegramType;
}