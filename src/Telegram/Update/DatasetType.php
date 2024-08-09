<?php

declare(strict_types=1);

namespace BDP\Telegram\Update;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class DatasetType
{
    public function __construct(private string $className)
    {
    }

    public function getClassName(): string
    {
        return $this->className;
    }
}