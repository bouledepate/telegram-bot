<?php

declare(strict_types=1);

namespace BDP\Telegram\Type;

use BDP\Telegram\Entity\Message\Date;
use BDP\Telegram\Entity\Message\MessageID;
use BDP\Telegram\Entity\Message\Text;

final readonly class Message implements TelegramType
{
    public MessageID $messageId;
    public User $from;
    public Chat $chat;
    public Date $date;
    public ?Message $replyToMessage;
    public Text $text;
    public MessageEntityCollection $entities;

    public function getMessageId(): MessageID
    {
        return $this->messageId;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function getDate(): Date
    {
        return $this->date;
    }

    public function getEntities(): MessageEntityCollection
    {
        return $this->entities;
    }

    public function getReplyToMessage(): ?Message
    {
        return $this->replyToMessage;
    }

    public function getText(): Text
    {
        return $this->text;
    }
}