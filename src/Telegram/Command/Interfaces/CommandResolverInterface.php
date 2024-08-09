<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Interfaces;

use BDP\Telegram\Command\Context\Context;
use BDP\Telegram\Command\Structure\Executable;
use BDP\Telegram\Update\Update;

interface CommandResolverInterface
{
    public function resolve(Update $update, Context $context): ?Executable;
}