<?php

declare(strict_types=1);

namespace BDP\Telegram\Type;

use BDP\Telegram\Entity\Message\MessageID as ID;

final readonly class MessageID implements TelegramType
{
    public ID $messageId;

    public function getID(): ID
    {
        return $this->messageId;
    }
}