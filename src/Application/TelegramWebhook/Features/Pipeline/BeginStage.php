<?php

declare(strict_types=1);

namespace BDP\Application\TelegramWebhook\Features\Pipeline;

use BDP\Telegram\Command\Structure\Stage;
use BDP\Telegram\Command\Structure\StageResponse;
use BDP\Telegram\Network\Interfaces\TelegramClient;
use BDP\Telegram\Network\Method\SendMessage\SendMessageData;

final class BeginStage extends Stage
{
    public function __construct(private readonly TelegramClient $client)
    {
    }

    public function run(): StageResponse
    {
        // Custom logic here.
        return StageResponse::Success;
    }

    public function success(): void
    {
        $chatID = $this->context->getChat()->getId()->getValue();
        $data = SendMessageData::build()
            ->setChatID($chatID)
            ->setText("Это первый шаг обработки пошаговой команды. " .
                "Пожалуйста, напиши мне ещё одно сообщение.");
        $this->client->sendMessage($data);
    }
}