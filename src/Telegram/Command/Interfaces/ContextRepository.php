<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Interfaces;

use BDP\Telegram\Command\Context\Context;
use BDP\Telegram\Entity\User\UserID;

interface ContextRepository
{
    public function fetchBy(UserID $userID): ?Context;

    public function save(Context $context): void;

    public function remove(Context $context): void;
}