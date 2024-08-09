<?php

declare(strict_types=1);

namespace BDP\Telegram\Network\Method\SendMessage;

use BDP\Telegram\Network\Common\TelegramRequestData;
use BDP\Telegram\Entity\Chat\ChatID;
use BDP\Telegram\Entity\Message\Text;
use BDP\Telegram\Type\MessageEntityCollection;
use BDP\Telegram\Entity\Options\Notification;
use BDP\Telegram\Entity\Options\ParseMode;
use BDP\Telegram\Entity\Options\ProtectContent;
use BDP\Telegram\Type\ReplyParameters;

final class SendMessageData extends TelegramRequestData
{
    public ChatID $chatId;
    public Text $text;
    public ParseMode $parseMode;
    public MessageEntityCollection $entities;
    public Notification $disableNotification;
    public ProtectContent $protectContent;
    public ReplyParameters $replyParameters;

    public static function build(): SendMessageData
    {
        return new SendMessageData();
    }

    public function setChatID(int|string $chatID): self
    {
        $this->chatId = new ChatID($chatID);
        return $this;
    }

    public function disableNotification(bool $state): self
    {
        $this->disableNotification = new Notification($state);
        return $this;
    }

    public function setEntities(array $entities): self
    {
        $this->entities = new MessageEntityCollection($entities);
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

    public function setText(string $text): self
    {
        $this->text = new Text($text);
        return $this;
    }
}