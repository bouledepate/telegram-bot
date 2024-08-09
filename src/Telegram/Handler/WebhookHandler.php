<?php

declare(strict_types=1);

namespace BDP\Telegram\Handler;

use BDP\Telegram\Command\Context\ContextFactory;
use BDP\Telegram\Command\Context\State;
use BDP\Telegram\Command\Interfaces\CommandResolverInterface;
use BDP\Telegram\Command\Interfaces\ContextRepository;
use BDP\Telegram\Update\Update;

final readonly class WebhookHandler implements WebhookHandlerInterface
{
    public function __construct(
        private ContextFactory $contextFactory,
        private ContextRepository $contextRepository,
        private CommandResolverInterface $commandResolver
    ) {
    }

    public function handle(Update $update): void
    {
        $userID = $update->getUser()->getId();
        $context = $this->contextRepository->fetchBy($userID);

        if (null === $context) {
            $context = $this->contextFactory->new($userID);
        }

        $executable = $this->commandResolver->resolve($update, $context);
        $executable->execute();

        $context->getCommand()->setName($executable::class);
        match ($context->getState()) {
            State::Keep => $this->contextRepository->save($context),
            State::Remove => $this->contextRepository->remove($context),
            State::Ignore => null
        };
    }
}