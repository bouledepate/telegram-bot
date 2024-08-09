<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Context;

use BDP\Kernel\Components\ValueObject\IntegerValueObject;

final class StageID extends IntegerValueObject
{
    public function next(): void
    {
        $this->value++;
    }

    public function previous(): void
    {
        $this->value--;
    }
}