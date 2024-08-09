<?php

declare(strict_types = 1);

namespace BDP\Telegram\Entity\Chat;

enum Type: string
{
    case Private = 'private';
    case Group = 'group';
    case Supergroup = 'supergroup';
    case Channel = 'channel';
}