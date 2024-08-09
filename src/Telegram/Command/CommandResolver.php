<?php

declare(strict_types=1);

namespace BDP\Telegram\Command;

use BDP\Telegram\Command\Builtin\UndefinedCommand;
use BDP\Telegram\Command\Context\Context;
use BDP\Telegram\Command\Interfaces\CommandProviderInterface;
use BDP\Telegram\Command\Interfaces\CommandResolverInterface;
use BDP\Telegram\Command\Structure\Command;
use BDP\Telegram\Command\Structure\Executable;
use BDP\Telegram\Command\Structure\Pipeline;
use BDP\Telegram\Entity\Message\Text;
use BDP\Telegram\Entity\MessageEntity\Type;
use BDP\Telegram\Type\Message;
use BDP\Telegram\Type\MessageEntity;
use BDP\Telegram\Type\MessageEntityCollection;
use BDP\Telegram\Update\Update;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

final readonly class CommandResolver implements CommandResolverInterface
{
    private Context $commandContext;
    private Update $executableContext;

    public function __construct(
        private CommandProviderInterface $provider,
        private ContainerInterface $container
    ) {
    }

    public function resolve(Update $update, Context $context): ?Executable
    {
        $this->commandContext = $context;
        $this->executableContext = $update;

        if ($context->getCommand()->isNull() === false) {
            return $this->produce($context->getCommand()->getValue());
        }

        $commands = $this->provider->getCommands();
        $updateData = $update->getUpdateData();

        if ($updateData instanceof Message) {
            $pattern = $this->fetchCommandPattern($updateData->getText(), $updateData->getEntities());
            $executable = $commands[$pattern] ?? null;
            if ($executable) {
                return $this->produce($executable);
            }
            return $this->handleUndefinedCommand();
        }

        // Any other telegram types not supported yet, so will be ignored.
        return null;
    }

    private function produce(string $className): ?Executable
    {
        try {
            if (is_subclass_of($className, Command::class)) {
                $instance = $this->container->get($className);
                $instance->setContext($this->executableContext);
            } elseif (is_subclass_of($className, Pipeline::class)) {
                $instance = new $className(
                    update: $this->executableContext,
                    context: $this->commandContext,
                    container: $this->container
                );
            } else {
                $instance = null;
            }
        } catch (ContainerExceptionInterface $exception) {
            throw new CommandNotInstantiable($className, previous: $exception);
        }
        return $instance;
    }

    private function fetchCommandPattern(Text $text, MessageEntityCollection $entities): string
    {
        $botCommand = null;
        $pattern = $text->getValue();

        /** @var MessageEntity $entity */
        foreach ($entities as $entity) {
            if ($entity->getType() === Type::BotCommand) {
                $botCommand = $entity;
                break;
            }
        }

        if ($botCommand) {
            $pattern = $text->getUnicodeString()->slice(
                start: $botCommand->getOffset()->getValue(),
                length: $botCommand->getLength()->getValue()
            );
        }

        return $pattern;
    }

    private function handleUndefinedCommand(): Executable
    {
        return $this->produce(UndefinedCommand::class);
    }
}