<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Redis;

use Exception;
use Throwable;

final class RedisUnavailable extends Exception
{
    public function __construct(?Throwable $previous = null)
    {
        $message = $previous !== null ? $previous->getMessage() : "Redis not available";
        parent::__construct($message, 0, $previous);
    }
}