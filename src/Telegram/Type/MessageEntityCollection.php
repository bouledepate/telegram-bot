<?php

declare(strict_types=1);

namespace BDP\Telegram\Type;

use BDP\Kernel\Components\ValueObject\Collection;

final class MessageEntityCollection extends Collection implements TelegramType
{
    function typeOf(): string
    {
        return MessageEntity::class;
    }
}