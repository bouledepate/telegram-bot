<?php

declare(strict_types=1);

namespace BDP\Telegram\Network\Method\CopyMessage;

use BDP\Telegram\Network\Common\TelegramRequest;

final class CopyMessageRequest extends TelegramRequest
{
    public function getRequestDataClass(): string
    {
        return CopyMessageData::class;
    }

    public function getMethodName(): string
    {
        return 'copyMessage';
    }
}