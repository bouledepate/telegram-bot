<?php

declare(strict_types=1);

namespace BDP\Telegram\Network\Interfaces;

use BDP\Telegram\Network\Method\CopyMessage\CopyMessageData;
use BDP\Telegram\Network\Method\CopyMessage\CopyMessageResponse;
use BDP\Telegram\Network\Method\GetCommands\GetCommandsResponse;
use BDP\Telegram\Network\Method\SendMessage\SendMessageData;
use BDP\Telegram\Network\Method\SendMessage\SendMessageResponse;

interface TelegramClient
{
    public function sendMessage(SendMessageData $data): SendMessageResponse;

    public function copyMessage(CopyMessageData $data): CopyMessageResponse;

    public function getCommands(): GetCommandsResponse;
}