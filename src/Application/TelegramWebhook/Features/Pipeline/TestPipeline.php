<?php

declare(strict_types=1);

namespace BDP\Application\TelegramWebhook\Features\Pipeline;

use BDP\Telegram\Command\Structure\Pipeline;

final class TestPipeline extends Pipeline
{
    protected array $stages = [
        BeginStage::class,
        FinishStage::class
    ];
}