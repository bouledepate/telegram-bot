<?php

declare(strict_types=1);

namespace BDP\Application\TelegramWebhook;

use BDP\Application\TelegramWebhook\Features\Command\TestCommand;
use BDP\Application\TelegramWebhook\Features\Pipeline\TestPipeline;
use BDP\Telegram\Command\Interfaces\CommandProviderInterface;

final class CommandProvider implements CommandProviderInterface
{
    public function getCommands(): array
    {
        return [
            '/command' => TestCommand::class,
            '/pipeline' => TestPipeline::class,
        ];
    }
}