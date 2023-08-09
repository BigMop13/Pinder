<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Dto\Registration\RegistrationInput;
use App\Exception\NoGenderFoundException;
use App\Service\Register\RegisterUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
readonly class UserRegistration
{
    public function __construct(
        private SerializerInterface $serializer,
        private RegisterUser $registerUser
    ) {
    }

    /**
     * @throws NoGenderFoundException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $registerData = $this->serializer->deserialize($request->getContent(), RegistrationInput::class, 'json');

        $this->registerUser->registerUser($registerData);

        return new JsonResponse('User created successfully');
    }
}
