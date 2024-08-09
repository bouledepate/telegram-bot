<?php

declare(strict_types=1);

namespace BDP\Telegram\Type;

use BDP\Telegram\Entity\Chat\ChatID;
use BDP\Telegram\Entity\Message\MessageID;

final readonly class ReplyParameters implements TelegramType
{
    public MessageID $messageId;
    public ChatID $chatId;

    public function getMessageId(): MessageID
    {
        return $this->messageId;
    }

    public function getChatId(): ChatID
    {
        return $this->chatId;
    }
}