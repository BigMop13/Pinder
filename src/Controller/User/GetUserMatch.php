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

        $userMatch = $this->userRepository->getUserMatch($user->getUserPreferences()); // todo dodać cache na userPreference od usera
        //dodaj query które wybiera z wykluczeniem id które są już w bazie redisa
        $this->matchesRepository->saveUserMatch($user->getId(), $userMatch->getId());

        return $this->json();
    }
}
