<?php
declare(strict_types=1);

namespace App\Repository\Interface;

interface UserMatchesRepositoryInterface
{
    public function getUserSeenMatches(int $userId): ?array;

    public function saveUserMatch(int $userId, int $matchId): void;
}