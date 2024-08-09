<?php

declare(strict_types=1);

namespace BDP\Telegram\Update;

use BDP\Telegram\Factory\Skip;
use BDP\Telegram\Type\Chat;
use BDP\Telegram\Type\TelegramType;
use BDP\Telegram\Type\User;

abstract class Update implements TelegramType
{
    #[Skip]
    protected UpdateType $updateType;
    public UpdateID $updateId;
    public TelegramType $updateData;

    public function getUpdateId(): UpdateID
    {
        return $this->updateId;
    }

    public function getUpdateData(): TelegramType
    {
        return $this->updateData;
    }

    public function getUpdateType(): UpdateType
    {
        return $this->updateType;
    }

    abstract public function getUser(): User;

    abstract public function getChat(): Chat;
}