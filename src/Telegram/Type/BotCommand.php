<?php

declare(strict_types=1);

namespace BDP\Telegram\Type;

use BDP\Telegram\Entity\BotCommand\Command;
use BDP\Telegram\Entity\BotCommand\Description;

final readonly class BotCommand implements TelegramType
{
    public Command $command;
    public Description $description;

    public function getCommand(): Command
    {
        return $this->command;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }
}