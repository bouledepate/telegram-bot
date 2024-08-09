<?php

declare(strict_types=1);

namespace BDP\Application;

use BDP\Application\CustomAction\TestController;
use BDP\Application\TelegramWebhook\CommandProvider;
use BDP\Kernel\Components\Container\ContainerProvider;
use BDP\Telegram\Command\Interfaces\CommandProviderInterface;

use function DI\autowire;
use function DI\get;

final readonly class ApplicationDefinitions implements ContainerProvider
{
    public function getDefinitions(): array
    {
        return [
            TestController::class => autowire(),
            CommandProviderInterface::class => get(CommandProvider::class),
        ];
    }
}