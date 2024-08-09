<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Environment;

enum Constant
{
    case LOG_ERRORS;
    case LOG_ERROR_DETAILS;
    case ERROR_DETAILS;
    case USE_SINGLE_ENTRYPOINT;
    case ENDPOINT;
    case DATABASE_HOST;
    case DATABASE_NAME;
    case DATABASE_USER;
    case DATABASE_PASSWORD;
    case DATABASE_PORT;
    case REDIS_HOST;
    case REDIS_PORT;
    case REDIS_USER;
    case REDIS_PASSWORD;
    case TELEGRAM_BOT_TOKEN;
    case TELEGRAM_HOST;
    case TELEGRAM_CONTEXT_STORAGE_ID;
}