<?php

declare(strict_types=1);

namespace BDP\Application\TelegramWebhook\Features\Pipeline;

use BDP\Telegram\Command\Structure\Stage;
use BDP\Telegram\Command\Structure\StageResponse;
use BDP\Telegram\Network\Interfaces\TelegramClient;
use BDP\Telegram\Network\Method\SendMessage\SendMessageData;

final class FinishStage extends Stage
{
    public function __construct(private readonly TelegramClient $client)
    {
    }

    public function run(): StageResponse
    {
        // Custom logic here.
        return StageResponse::Finished;
    }

    public function finish(): void
    {
        $chatID = $this->context->getChat()->getId()->getValue();
        $data = SendMessageData::build()
            ->setChatID($chatID)
            ->setText("Это финальный шаг обработки пошаговой команды. " .
                "Твой следующий ввод будет идентифицирован, как входящая команда.");
        $this->client->sendMessage($data);
    }
}