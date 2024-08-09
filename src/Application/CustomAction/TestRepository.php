<?php

declare(strict_types=1);

namespace BDP\Application\CustomAction;

use BDP\Kernel\Components\Database\AbstractRepository;

final class TestRepository extends AbstractRepository
{
    public function testConnection(): bool
    {
        $connection = $this->connection->getConnection();
        return $connection->isConnected();
    }
}