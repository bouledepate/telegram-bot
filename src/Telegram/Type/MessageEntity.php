<?php

declare(strict_types=1);

namespace BDP\Telegram\Type;

use BDP\Telegram\Entity\MessageEntity\EmojiID;
use BDP\Telegram\Entity\MessageEntity\Length;
use BDP\Telegram\Entity\MessageEntity\Offset;
use BDP\Telegram\Entity\MessageEntity\Type as MessageEntityType;
use BDP\Telegram\Entity\MessageEntity\Url;

final readonly class MessageEntity implements TelegramType
{
    public MessageEntityType $type;
    public Offset $offset;
    public Length $length;
    public Url $url;
    public ?User $user;
    public EmojiID $customEmojiId;

    public function getType(): MessageEntityType
    {
        return $this->type;
    }

    public function getOffset(): Offset
    {
        return $this->offset;
    }

    public function getLength(): Length
    {
        return $this->length;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getCustomEmojiId(): EmojiID
    {
        return $this->customEmojiId;
    }
}