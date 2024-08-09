<?php

declare(strict_types=1);

namespace BDP\Application\TelegramWebhook;

use BDP\Kernel\Components\Routing\Entrypoint;
use BDP\Telegram\Factory\TypeFactoryInterface;
use BDP\Telegram\Handler\WebhookHandlerInterface;
use BDP\Telegram\Update\Update;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final readonly class WebhookController implements Entrypoint
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private TypeFactoryInterface $typeFactory,
        private WebhookHandlerInterface $webhookHandler
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $update = $this->getUpdateFrom($request);
        if ($update instanceof Update) {
            $this->webhookHandler->handle($update);
        }
        return $this->responseFactory->createResponse(204);
    }

    private function getUpdateFrom(ServerRequestInterface $request): ?Update
    {
        $requestBody = $request->getParsedBody();
        if (empty($requestBody)) {
            return null;
        }
        $update = $this->typeFactory->produce(Update::class, $requestBody);
        if (!$update instanceof Update) {
            return null;
        }
        return $update;
    }
}