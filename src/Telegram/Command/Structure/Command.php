<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Structure;

use BDP\Telegram\Update\Update;

abstract class Command implements Executable
{
    protected Update $context;

    final public function setContext(Update $context): void
    {
        $this->context = $context;
    }
}