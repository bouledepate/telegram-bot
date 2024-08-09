<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Structure;

use LogicException;

final class StageNotExecutable extends LogicException
{
    protected $message = 'Stage not executable. Make sure you add it to the Pipeline::$stages property.';
}