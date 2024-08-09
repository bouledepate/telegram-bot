<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Structure;

interface Executable
{
    public function execute(): void;
}