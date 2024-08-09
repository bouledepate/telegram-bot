<?php

declare(strict_types=1);

namespace BDP\Telegram\Command;

use LogicException;
use Throwable;

final class CommandNotInstantiable extends LogicException
{
    public function __construct(string $className, ?Throwable $previous = null)
    {
        $message = sprintf("Command %s not instantiable.", $className);
        parent::__construct($message, 0, $previous);
    }
}