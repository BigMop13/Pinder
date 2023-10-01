<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Repository\Interface\UserMatchesRepositoryInterface;
use App\Repository\Interface\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class GetUserMatch extends AbstractController
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserMatchesRepositoryInterface $matchesRepository,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $alreadySeenIds = $this->matchesRepository->getUserSeenMatches($userId);
        $alreadySeenIds[] += $userId;

        $userMatch = $this->userRepository->getUserMatch(
            $user->getUserPreferences(),
            $alreadySeenIds,
        );

        if (!$userMatch) {
            return $this->json($this->userRepository->getRandomUser($userId));
        }
        $this->matchesRepository->saveUserMatch($userId, $userMatch->getId());

        return $this->json($userMatch);
    }
}
