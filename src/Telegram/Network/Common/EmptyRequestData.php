<?php

declare(strict_types = 1);

namespace BDP\Telegram\Network\Common;

final class EmptyRequestData extends TelegramRequestData
{
    public static function build(): TelegramRequestData
    {
        return new self();
    }
}