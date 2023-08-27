<?php
declare(strict_types=1);

namespace App\Controller\User;

use Kreait\Firebase\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class GetUserToken extends AbstractController
{
    public function __construct(private readonly Factory $factory, private readonly string $firebaseAuthCredentials)
    {
    }

    #[Route(path: 'get_user_token', name: 'get_user_token', methods: Request::METHOD_POST)]
    public function __invoke(Request $request): JsonResponse
    {
        $firebase = $this->factory->withServiceAccount(sprintf('../%s', $this->firebaseAuthCredentials));
        $auth = $firebase->createAuth();
        $requestData = $request->toArray();

        $user = $auth->signInWithEmailAndPassword(
            $requestData['email'],
            $requestData['password']
        );

        return new JsonResponse($user->idToken());
    }
}