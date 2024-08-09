<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Infrastructure;

use BDP\Kernel\Components\Config\TelegramConfig;
use BDP\Kernel\Components\Environment\Constant;
use BDP\Kernel\Components\Redis\RedisConnectionInterface;
use BDP\Kernel\Components\Redis\RedisRepository;
use BDP\Telegram\Command\Context\Context;
use BDP\Telegram\Command\Context\ContextFactory;
use BDP\Telegram\Command\Interfaces\ContextRepository;
use BDP\Telegram\Entity\User\UserID;
use RedisException;

final class RedisContextRepository extends RedisRepository implements ContextRepository
{
    public function __construct(
        RedisConnectionInterface $redisConnection,
        private readonly TelegramConfig $configuration,
        private readonly ContextFactory $contextFactory
    ) {
        parent::__construct($redisConnection);
    }

    protected function getDatabase(): int
    {
        return $this->configuration->getValue(Constant::TELEGRAM_CONTEXT_STORAGE_ID);
    }

    /** @throws RedisException */
    public function fetchBy(UserID $userID): ?Context
    {
        $data = $this->getAllHash((string)$userID);
        if (empty($data)) {
            return null;
        }
        return $this->contextFactory->produce(array_merge(['user_id' => $userID->getValue()], $data));
    }

    /**
     * @throws RedisException
     */
    public function save(Context $context): void
    {
        $userID = (string)$context->getUserID();
        $data = [
            'command_name' => $context->getCommand()->getValue(),
            'stage_id' => $context->getStageID()->getValue(),
            'executed_at' => $context->getExecutedAt()->getValue()
        ];
        $this->setHash($userID, $data);
        $this->setExpire($userID, 120);
    }

    /** @throws RedisException */
    public function remove(Context $context): void
    {
        $userID = (string)$context->getUserID();
        $this->delete($userID);
    }
}