<?php

declare(strict_types=1);

namespace BDP\Telegram\Entity\Options;

enum ParseMode: string
{
    case HTML = 'HTML';
    case Markdown = 'Markdown';
    case MarkdownV2 = 'MarkdownV2';
}