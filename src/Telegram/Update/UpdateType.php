<?php

declare(strict_types=1);

namespace BDP\Telegram\Update;

enum UpdateType: string
{
    case Message = 'message';
    case EditedMessage = 'edited_message';
    case Undefined = 'undefined';
}