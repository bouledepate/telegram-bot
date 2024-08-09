<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Config;

use BDP\Kernel\Components\Config\Structure\AbstractEnvConfig;
use BDP\Kernel\Components\Environment\Constant;

final readonly class TelegramConfig extends AbstractEnvConfig
{
    private string $token;
    private string $host;
    private int $storageID;

    protected function constantMap(): array
    {
        return [
            'token' => Constant::TELEGRAM_BOT_TOKEN,
            'host' => Constant::TELEGRAM_HOST,
            'storageID' => Constant::TELEGRAM_CONTEXT_STORAGE_ID
        ];
    }
}