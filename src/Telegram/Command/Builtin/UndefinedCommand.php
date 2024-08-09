<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Builtin;

use BDP\Telegram\Command\Structure\Command;
use BDP\Telegram\Network\Interfaces\TelegramClient;
use BDP\Telegram\Network\Method\SendMessage\SendMessageData;
use BDP\Telegram\Type\Message;

final class UndefinedCommand extends Command
{
    public function __construct(private readonly TelegramClient $client)
    {
    }

    public function execute(): void
    {
        /** @var Message $message */
        $message = $this->context->getUpdateData();
        $chatID = $message->getChat()->getId()->getValue();

        $data = SendMessageData::build()
            ->setChatID($chatID)
            ->setText('К сожалению, выбранная команда мне неизвестна. Пожалуйста, обратитесь к справочнику.');

        $this->client->sendMessage($data);
    }
}