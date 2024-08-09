<?php

declare(strict_types=1);

namespace BDP\Telegram\Network\Method\SendMessage;

use BDP\Telegram\Network\Common\TelegramRequest;

final class SendMessageRequest extends TelegramRequest
{
    public function getRequestDataClass(): string
    {
        return SendMessageData::class;
    }

    public function getMethodName(): string
    {
       return 'sendMessage';
    }
}