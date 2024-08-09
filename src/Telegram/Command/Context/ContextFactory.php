<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Context;

use BDP\Telegram\Entity\User\UserID;

final readonly class ContextFactory
{
    public function new(UserID $userID): Context
    {
        return new Context(
            userID: $userID,
            command: new CommandName(null),
            stageID: new StageID(0),
            executedAt: new ExecutedAt(),
            state: State::Ignore
        );
    }

    public function produce(array $data): Context
    {
        return new Context(
            userID: new UserID((int)$data['user_id']),
            command: new CommandName($data['command_name']),
            stageID: new StageID((int)$data['stage_id']),
            executedAt: new ExecutedAt((int)$data['executed_at']),
            state: State::Ignore
        );
    }
}