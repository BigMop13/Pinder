<?php

declare(strict_types=1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class LoginUser extends AbstractController
{
    public function __construct()
    {
    }

    #[Route(path: 'login', name: 'login', methods: Request::METHOD_GET)]
    public function __invoke(Request $request): JsonResponse
    {
        return $this->json($this->getUser());
    }
}
