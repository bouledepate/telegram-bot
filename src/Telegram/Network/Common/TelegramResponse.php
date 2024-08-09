<?php

declare(strict_types=1);

namespace BDP\Telegram\Network\Common;

use BDP\Telegram\Type\Type;

/**
 * @template ResponseData of Type
 */
abstract class TelegramResponse
{
    public function __construct(
        /** @var ResponseData */
        protected object $data
    ) {
    }

    /**
     * @return class-string<ResponseData>
     */
    abstract public function getResponseType(): string;

    /**
     * @return ResponseData
     */
    public function getData(): object
    {
        return $this->data;
    }
}