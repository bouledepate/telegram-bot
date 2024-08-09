<?php

declare(strict_types=1);

namespace BDP\Telegram\Update\Assembly;

use BDP\Telegram\Update\Type\EditedMessageUpdate;
use BDP\Telegram\Update\Type\MessageUpdate;
use BDP\Telegram\Update\UpdateType;

final class AssemblyManager implements AssemblyManagerInterface
{
    public function identifyUpdate(array $updateData): UpdateType
    {
        return match (true) {
            isset($updateData['message']) => UpdateType::Message,
            isset($updateData['edited_message']) => UpdateType::EditedMessage,
            default => UpdateType::Undefined
        };
    }

    public function fetchUpdateInstance(UpdateType $updateType): string
    {
        return match ($updateType) {
            UpdateType::Message => MessageUpdate::class,
            UpdateType::EditedMessage => EditedMessageUpdate::class,
            UpdateType::Undefined => null,
        };
    }
}