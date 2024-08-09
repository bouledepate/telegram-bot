<?php

declare(strict_types=1);

namespace BDP\Telegram\Network;

use BDP\Telegram\Factory\TypeFactoryInterface;
use BDP\Telegram\Network\Common\EmptyRequestData;
use BDP\Telegram\Network\Common\TelegramResponse;
use BDP\Telegram\Network\Interfaces\HttpClient;
use BDP\Telegram\Network\Interfaces\TelegramClient;
use BDP\Telegram\Network\Method\CopyMessage\CopyMessageData;
use BDP\Telegram\Network\Method\CopyMessage\CopyMessageRequest;
use BDP\Telegram\Network\Method\CopyMessage\CopyMessageResponse;
use BDP\Telegram\Network\Method\GetCommands\GetCommandsRequest;
use BDP\Telegram\Network\Method\GetCommands\GetCommandsResponse;
use BDP\Telegram\Network\Method\SendMessage\SendMessageData;
use BDP\Telegram\Network\Method\SendMessage\SendMessageRequest;
use BDP\Telegram\Network\Method\SendMessage\SendMessageResponse;
use BDP\Telegram\Type\TelegramType;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;
use ReflectionException;

final readonly class ClientWrapper implements TelegramClient
{
    public function __construct(
        private HttpClient $client,
        private TypeFactoryInterface $typeFactory
    ) {
    }

    /** @throws ReflectionException */
    public function sendMessage(SendMessageData $data): SendMessageResponse
    {
        $request = new SendMessageRequest($data);
        $responseData = $this->typecastResponse(
            response: $this->client->send($request),
            responseClass: SendMessageResponse::class
        );

        return new SendMessageResponse($responseData);
    }

    /** @throws ReflectionException */
    public function copyMessage(CopyMessageData $data): CopyMessageResponse
    {
        $request = new CopyMessageRequest($data);
        $responseData = $this->typecastResponse(
            response: $this->client->send($request),
            responseClass: CopyMessageResponse::class
        );

        return new CopyMessageResponse($responseData);
    }

    /** @throws ReflectionException */
    public function getCommands(): GetCommandsResponse
    {
        $request = new GetCommandsRequest(new EmptyRequestData());
        $response = $this->typecastResponse(
            response: $this->client->send($request),
            responseClass: GetCommandsResponse::class
        );

        return new GetCommandsResponse($response);
    }

    /** @throws ReflectionException */
    private function typecastResponse(ResponseInterface $response, string $responseClass): TelegramType
    {
        $expectedType = $this->getType($responseClass);
        $responseData = json_decode($response->getBody()->getContents(), true);

        return $this->typeFactory->produce($expectedType, $responseData['result']);
    }

    /** @throws ReflectionException */
    private function getType(string $responseClass): string
    {
        $reflection = new ReflectionClass($responseClass);
        /** @var TelegramResponse $instance */
        $instance = $reflection->newInstanceWithoutConstructor();
        return $instance->getResponseType();
    }
}