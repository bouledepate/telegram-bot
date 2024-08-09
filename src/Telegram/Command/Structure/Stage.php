<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Structure;

use BDP\Telegram\Update\Update;

abstract class Stage implements StageInterface
{
    protected readonly Update $context;

    final public function setContext(Update $context): void
    {
        $this->context = $context;
    }

    public function success(): void
    {
    }

    public function failed(): void
    {
    }

    public function finish(): void
    {
    }

    public function rollback(): void
    {
    }

    public function abort(): void
    {
    }
}