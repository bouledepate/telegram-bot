<?php

declare(strict_types=1);

namespace BDP\Telegram\Handler;

use BDP\Telegram\Update\Update;

interface WebhookHandlerInterface
{
    public function handle(Update $update): void;
}