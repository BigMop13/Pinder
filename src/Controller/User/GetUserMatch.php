<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Repository\Interface\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class GetUserMatch extends AbstractController
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $user = $this->getUser();

        return $this->json($this->userRepository->getUserMatches($user->getUserPreferences())); // todo dodać cache na userPreference od usera
    }
}
