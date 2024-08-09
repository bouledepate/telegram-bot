<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Context;

use BDP\Kernel\Components\ValueObject\StringValueObject;
use function Symfony\Component\String\u;

final class CommandName extends StringValueObject
{
    public function setName(string $name): void
    {
        $this->value = u($name);
    }
}