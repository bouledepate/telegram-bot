<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Context;

use BDP\Telegram\Entity\User\UserID;

final class Context
{
    public function __construct(
        private readonly UserID $userID,
        private readonly CommandName $command,
        private readonly StageID $stageID,
        private readonly ExecutedAt $executedAt,
        private State $state
    ) {
    }

    public function getUserID(): UserID
    {
        return $this->userID;
    }

    public function getCommand(): CommandName
    {
        return $this->command;
    }

    public function getStageID(): StageID
    {
        return $this->stageID;
    }

    public function getExecutedAt(): ExecutedAt
    {
        return $this->executedAt;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function keep(): void
    {
        $this->state = State::Keep;
    }

    public function remove(): void
    {
        $this->state = State::Remove;
    }

    public function ignore(): void
    {
        $this->state = State::Ignore;
    }
}