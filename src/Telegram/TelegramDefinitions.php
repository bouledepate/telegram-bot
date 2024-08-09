<?php

declare(strict_types=1);

namespace BDP\Telegram;

use BDP\Kernel\Components\Container\ContainerProvider;
use BDP\Telegram\Command\CommandResolver;
use BDP\Telegram\Command\Infrastructure\RedisContextRepository;
use BDP\Telegram\Command\Interfaces\CommandResolverInterface;
use BDP\Telegram\Command\Interfaces\ContextRepository;
use BDP\Telegram\Handler\WebhookHandler;
use BDP\Telegram\Handler\WebhookHandlerInterface;
use BDP\Telegram\Network\ClientWrapper;
use BDP\Telegram\Network\HttpClient;
use BDP\Telegram\Network\Interfaces\HttpClient as HttpClientInterface;
use BDP\Telegram\Network\Interfaces\TelegramClient;
use BDP\Telegram\Factory\TypeFactory;
use BDP\Telegram\Factory\TypeFactoryInterface;
use BDP\Telegram\Update\Assembly\AssemblyManager;
use BDP\Telegram\Update\Assembly\AssemblyManagerInterface;
use function DI\autowire;

final readonly class TelegramDefinitions implements ContainerProvider
{
    public function getDefinitions(): array
    {
        return [
            TypeFactoryInterface::class => autowire(TypeFactory::class),
            HttpClientInterface::class => autowire(HttpClient::class),
            TelegramClient::class => autowire(ClientWrapper::class),
            AssemblyManagerInterface::class => autowire(AssemblyManager::class),
            CommandResolverInterface::class => autowire(CommandResolver::class),
            WebhookHandlerInterface::class => autowire(WebhookHandler::class),
            ContextRepository::class => autowire(RedisContextRepository::class),
        ];
    }
}