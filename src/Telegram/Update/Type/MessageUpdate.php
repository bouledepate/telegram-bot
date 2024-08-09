<?php

declare(strict_types=1);

namespace BDP\Telegram\Update\Type;

use BDP\Telegram\Factory\Skip;
use BDP\Telegram\Type\Chat;
use BDP\Telegram\Type\Message;
use BDP\Telegram\Type\User;
use BDP\Telegram\Update\DatasetType;
use BDP\Telegram\Update\Update;
use BDP\Telegram\Update\UpdateType;

/** @method Message getUpdateData() */
#[DatasetType(className: Message::class)]
final class MessageUpdate extends Update
{
    #[Skip]
    protected UpdateType $updateType = UpdateType::Message;

    public function getUser(): User
    {
        return $this->getUpdateData()->getFrom();
    }

    public function getChat(): Chat
    {
        return $this->getUpdateData()->getChat();
    }
}