<?php

declare(strict_types=1);

namespace BDP\Telegram\Update\Assembly;

use BDP\Telegram\Update\UpdateType;

interface AssemblyManagerInterface
{
    public function identifyUpdate(array $updateData): UpdateType;

    public function fetchUpdateInstance(UpdateType $updateType): ?string;
}