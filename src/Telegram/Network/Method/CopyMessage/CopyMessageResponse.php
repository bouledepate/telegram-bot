<?php

declare(strict_types = 1);

namespace BDP\Telegram\Network\Method\CopyMessage;

use BDP\Telegram\Network\Common\TelegramResponse;
use BDP\Telegram\Type\MessageID;

final class CopyMessageResponse extends TelegramResponse
{
    public function getResponseType(): string
    {
        return MessageID::class;
    }
}