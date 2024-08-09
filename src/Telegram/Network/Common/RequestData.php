<?php

declare(strict_types = 1);

namespace BDP\Telegram\Network\Common;

interface RequestData
{
    public function asJson(): string;

    public function asArray(): array;
}