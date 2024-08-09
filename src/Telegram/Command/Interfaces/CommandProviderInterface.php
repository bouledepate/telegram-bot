<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Interfaces;

interface CommandProviderInterface
{
    public function getCommands(): array;
}