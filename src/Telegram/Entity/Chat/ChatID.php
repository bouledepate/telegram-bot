<?php

declare(strict_types=1);

namespace BDP\Telegram\Entity\Chat;

use BDP\Kernel\Components\ValueObject\StringValueObject;

final class ChatID extends StringValueObject
{
    public function __construct(string|int|null $value)
    {
        if (is_int($value)) {
            $value = (string)$value;
        }
        $this->ensureNumber($value);
        parent::__construct($value);
    }

    private function ensureNumber(mixed &$value): void
    {
        if (false === is_numeric($value)) {
            $value = null;
        }
    }
}