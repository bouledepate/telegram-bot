<?php

declare(strict_types = 1);

namespace BDP\Telegram\Type;

use BDP\Kernel\Components\ValueObject\Collection;

final class BotCommandCollection extends Collection implements TelegramType
{
    public function typeOf(): string
    {
        return BotCommand::class;
    }
}