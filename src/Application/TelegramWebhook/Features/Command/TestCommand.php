<?php

declare(strict_types=1);

namespace BDP\Application\TelegramWebhook\Features\Command;

use BDP\Telegram\Command\Structure\Command;
use BDP\Telegram\Network\Interfaces\TelegramClient;
use BDP\Telegram\Network\Method\SendMessage\SendMessageData;

final class TestCommand extends Command
{
    public function __construct(private readonly TelegramClient $client)
    {
    }

    public function execute(): void
    {
        $chat = $this->context->getChat();
        $data = SendMessageData::build()
            ->setChatID($chat->getId()->getValue())
            ->setText("Привет. Это обычная тестовая команда.");
        $this->client->sendMessage($data);
    }
}