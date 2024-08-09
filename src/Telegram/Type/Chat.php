<?php

namespace BDP\Telegram\Type;

use BDP\Telegram\Entity\Chat\ChatID;
use BDP\Telegram\Entity\Chat\Type as ChatType;

final readonly class Chat implements TelegramType
{
    public ChatId $id;
    public ChatType $type;

    public function getId(): ChatID
    {
        return $this->id;
    }

    public function getType(): ChatType
    {
        return $this->type;
    }
}