<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Environment;

use Dotenv\Dotenv;

final readonly class DotenvUploader
{
    private DotenvWrapper $env;

    public function __construct()
    {
        $this->env = new DotenvWrapper(Dotenv::createImmutable(paths: $this->getPaths()));
        $this->env->getDotenv()->load();
    }

    public function validate(): void
    {
        $this->env->required(
            Constant::LOG_ERRORS,
            Constant::LOG_ERROR_DETAILS,
            Constant::ERROR_DETAILS,
            Constant::USE_SINGLE_ENTRYPOINT
        )->isBoolean();

        $this->env->required(Constant::ENDPOINT)->notEmpty();

        $this->env->required(
            Constant::DATABASE_HOST,
            Constant::DATABASE_NAME,
            Constant::DATABASE_USER,
            Constant::DATABASE_PASSWORD,
            Constant::DATABASE_PORT,
        )->notEmpty();

        $this->env->required(Constant::REDIS_HOST, Constant::REDIS_USER, Constant::REDIS_PASSWORD,)->notEmpty();
        $this->env->required(Constant::REDIS_PORT)->isInteger();

        $this->env->required(Constant::TELEGRAM_BOT_TOKEN, Constant::TELEGRAM_HOST)->notEmpty();
        $this->env->required(Constant::TELEGRAM_CONTEXT_STORAGE_ID)->isInteger();
    }

    private function getPaths(): array
    {
        return [
            dirname(__DIR__, 4),
        ];
    }
}