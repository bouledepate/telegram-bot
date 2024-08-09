<?php

declare(strict_types=1);

namespace BDP\Telegram\Network;

use BDP\Kernel\Components\Config\TelegramConfig;
use BDP\Kernel\Components\Environment\Constant;
use BDP\Telegram\Network\Common\TelegramRequest;
use BDP\Telegram\Network\Interfaces\HttpClient as HttpClientInterface;
use Exception;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Factory\ServerRequestFactory;

final readonly class HttpClient implements HttpClientInterface
{
    public function __construct(
        private GuzzleClientInterface $client,
        private TelegramConfig $configuration
    ) {
    }

    /**
     * @throws Exception
     */
    public function send(TelegramRequest $telegramRequest): ResponseInterface
    {
        try {
            $telegramRequest = $telegramRequest->withHeaders([
                'Content-Type' => 'application/json',
            ]);
            $requestOptions = [
                RequestOptions::HEADERS => $telegramRequest->getHeaders(),
                RequestOptions::BODY => $telegramRequest->asJSON()
            ];
            $response = $this->client->request(
                method: $telegramRequest->getMethod(),
                uri: $this->getHost($telegramRequest),
                options: $requestOptions
            );
        } catch (ClientException $exception) {
            $this->handleClientException($exception);
        } catch (GuzzleException $exception) {
            throw new Exception('something went wrong: ' . $exception->getMessage());
        }
        return $response;
    }

    private function handleClientException(ClientException $exception): never
    {
        $serverRequest = ServerRequestFactory::createFromGlobals();
        $responseBody = json_decode($exception->getResponse()->getBody()->getContents(), true);
        throw new HttpBadRequestException($serverRequest, $responseBody['description'] ?? "Bad request.", $exception);
    }

    private function getHost(TelegramRequest $request): string
    {
        return $this->configuration->getValue(Constant::TELEGRAM_HOST) . $request->getMethodName();
    }
}