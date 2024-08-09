<?php

declare(strict_types=1);

namespace BDP\Telegram\Network\Method\CopyMessage;

use BDP\Telegram\Network\Common\TelegramRequestData;
use BDP\Telegram\Entity\Chat\ChatID;
use BDP\Telegram\Entity\Message\MessageID;
use BDP\Telegram\Entity\Options\Notification;
use BDP\Telegram\Entity\Options\ParseMode;
use BDP\Telegram\Entity\Options\ProtectContent;
use BDP\Telegram\Type\ReplyParameters;

final class CopyMessageData extends TelegramRequestData
{
    public ChatID $chatId;
    public ChatID $fromChatId;
    public MessageID $messageId;
    public ParseMode $parseMode;
    public Notification $disableNotification;
    public ProtectContent $protectContent;
    public ReplyParameters $replyParameters;

    public static function build(): CopyMessageData
    {
        return new CopyMessageData();
    }

    public function setChatID(int|string $chatID): self
    {
        $this->chatId = new ChatID($chatID);
        return $this;
    }

    public function setFromChatId(int|string $chatID): self
    {
        $this->fromChatId = new ChatID($chatID);
        return $this;
    }

    public function setMessageId(int $ID): self
    {
        $this->messageId = new MessageID($ID);
        return $this;
    }

    public function disableNotification(bool $state): self
    {
        $this->disableNotification = new Notification($state);
        return $this;
    }

    public function setParseMode(ParseMode $parseMode): self
    {
        $this->parseMode = $parseMode;
        return $this;
    }

    public function protectContent(bool $state): self
    {
        $this->protectContent = new ProtectContent($state);
        return $this;
    }

    public function setReplyParameters(ReplyParameters $replyParameters): self
    {
        $this->replyParameters = $replyParameters;
        return $this;
    }
}