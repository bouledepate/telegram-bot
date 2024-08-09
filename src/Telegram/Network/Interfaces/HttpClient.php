<?php

declare(strict_types=1);

namespace BDP\Telegram\Network\Interfaces;

use BDP\Telegram\Network\Common\TelegramRequest;
use Psr\Http\Message\ResponseInterface;

interface HttpClient
{
    public function send(TelegramRequest $telegramRequest): ResponseInterface;
}