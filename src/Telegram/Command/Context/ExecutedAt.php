<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Context;

use BDP\Kernel\Components\ValueObject\TimestampValueObject;
use DateTimeImmutable;
use Throwable;

final class ExecutedAt extends TimestampValueObject
{
    public function setCurrent(): void
    {
        $this->value = time();
        try {
            $this->time = new DateTimeImmutable(date(TimestampValueObject::FORMAT, $this->value));
        } catch (Throwable) {
            $this->time = null;
        }
    }
}