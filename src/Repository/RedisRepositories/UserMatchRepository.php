<?php
declare(strict_types=1);

namespace App\Repository\RedisRepositories;

use App\Repository\Clients\RedisClient;
use App\Repository\Interface\UserMatchesRepositoryInterface;

readonly class UserMatchRepository implements UserMatchesRepositoryInterface
{
    public function __construct(private RedisClient $client)
    {
    }

    public function getUserSeenMatches(int $userId): ?array
    {
        return (array) $this->client->getRedisClient()->get((string) $userId);
    }

    public function saveUserMatch(int $userId, int $matchId): void
    {
        $this->client->getRedisClient()->sadd((string) $userId, (array) $matchId);
    }
}