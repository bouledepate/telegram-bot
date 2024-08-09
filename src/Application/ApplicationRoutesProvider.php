<?php

declare(strict_types=1);

namespace BDP\Application;

use BDP\Application\CustomAction\TestController;
use BDP\Application\TelegramWebhook\WebhookController;
use BDP\Kernel\Components\Routing\Route;
use BDP\Kernel\Components\Routing\RouteProvider;

class ApplicationRoutesProvider implements RouteProvider
{
    public function getRoutes(): array
    {
        return [
            Route::get('/test-route', TestController::class),
            Route::post('/webhook', [WebhookController::class, 'handle']),
        ];
    }
}