<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Context;

enum State: int
{
    case Keep = 1;
    case Remove = 2;
    case Ignore = 3;
}