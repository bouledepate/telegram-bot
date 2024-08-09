<?php

declare(strict_types=1);

namespace BDP\Telegram\Network\Method\SendMessage;

use BDP\Telegram\Network\Common\TelegramResponse;
use BDP\Telegram\Type\Message;

/** @extends TelegramResponse<Message> */
final class SendMessageResponse extends TelegramResponse
{
    public function getResponseType(): string
    {
        return Message::class;
    }
}