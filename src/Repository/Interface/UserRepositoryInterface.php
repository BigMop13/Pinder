<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\User;
use App\Entity\UserPreference;

interface UserRepositoryInterface
{
    public function getUserMatch(UserPreference $currentUserPreference, ?array $alreadySeenIds): ?User;

    public function getRandomUser(int $currentUserId): User;
}
