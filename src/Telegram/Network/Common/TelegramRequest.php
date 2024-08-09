<?php

declare(strict_types=1);

namespace BDP\Telegram\Network\Common;


use InvalidArgumentException;
use function Symfony\Component\String\u;

abstract class TelegramRequest
{
    protected readonly RequestData $requestData;
    protected string $method = 'POST';
    protected array $headers = [];

    public function __construct(RequestData $requestData)
    {
        if ($this->isRequestDataInvalid($requestData)) {
            $this->throwValidationError();
        }
        $this->requestData = $requestData;
    }

    abstract public function getRequestDataClass(): string;

    abstract public function getMethodName(): string;

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getBody(): array
    {
        return $this->convertBody($this->getRequestData()->asArray());
    }

    public function asJSON(): string
    {
        return json_encode($this->getBody(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getRequestData(): RequestData
    {
        return $this->requestData;
    }

    public function withHeaders(array $headers): TelegramRequest
    {
        $clone = clone $this;
        $clone->headers = $headers;

        return $clone;
    }

    private function isRequestDataInvalid(RequestData $data): bool
    {
        return $this->getRequestDataClass() !== $data::class;
    }

    private function throwValidationError(): never
    {
        throw new InvalidArgumentException('Request data must be a subclass of ' . $this->getRequestDataClass());
    }

    private function convertBody(array $data): array
    {
        $out = [];
        foreach ($data as $key => $value) {
            $key = u($key);
            $out[$key->snake()->toString()] = is_array($value)
                ? $this->convertBody($value)
                : $value;
        }
        return $out;
    }
}