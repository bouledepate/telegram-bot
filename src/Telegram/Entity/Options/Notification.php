<?php

declare(strict_types=1);

namespace BDP\Telegram\Entity\Options;

use BDP\Kernel\Components\ValueObject\BooleanValueObject;

final class Notification extends BooleanValueObject
{
    public function __construct(bool $value = false)
    {
        parent::__construct($value);
    }
}