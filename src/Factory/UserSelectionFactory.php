<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\UserSelection;

final class UserSelectionFactory
{
    public static function createUserSelection(int $choosingUserId, int $ratedUserId, bool $rate): UserSelection
    {
        return (new UserSelection())
            ->setChoosingUserId($choosingUserId)
            ->setRatedUserId($ratedUserId)
            ->setRate($rate);
    }
}
