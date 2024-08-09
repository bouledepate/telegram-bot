<?php

declare(strict_types=1);

namespace BDP\Telegram\Type;

use BDP\Telegram\Entity\User\FirstName;
use BDP\Telegram\Entity\User\LastName;
use BDP\Telegram\Entity\User\Premium;
use BDP\Telegram\Entity\User\UserID;
use BDP\Telegram\Entity\User\Username;

final readonly class User implements TelegramType
{
    public UserID $id;
    public Username $username;
    public FirstName $firstName;
    public LastName $lastName;
    public Premium $isPremium;

    public function getId(): UserID
    {
        return $this->id;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    public function getPremium(): Premium
    {
        return $this->isPremium;
    }
}