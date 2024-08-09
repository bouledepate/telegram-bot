<?php

declare(strict_types=1);

namespace BDP\Telegram\Network\Common;

abstract class TelegramRequestData implements RequestData
{
    abstract public static function build(): self;

    public function asJson(): string
    {
        return json_encode($this, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function asArray(): array
    {
        return json_decode($this->asJson(), true);
    }
}