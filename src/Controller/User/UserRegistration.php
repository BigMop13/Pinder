<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Dto\Registration\RegistrationInput;
use App\Service\Register\RegisterUser;
use App\Trait\ViolationErrorsTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
readonly class UserRegistration
{
    use ViolationErrorsTrait;

    public function __construct(
        private SerializerInterface $serializer,
        private RegisterUser $registerUser,
        private ValidatorInterface $validator,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $registerData = $this->serializer->deserialize($request->getContent(), RegistrationInput::class, 'json');

        $violations = $this->validator->validate($registerData);

        if (count($violations) > 0) {
            return new JsonResponse(['errors' => $this->extractErrorsFromViolations($violations)], Response::HTTP_BAD_REQUEST);
        }

        $this->registerUser->createUser($registerData);

        return new JsonResponse('User created successfully', Response::HTTP_CREATED);
    }
}
