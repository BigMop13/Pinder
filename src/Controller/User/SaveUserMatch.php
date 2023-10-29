<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Dto\User\UserSelectionInput;
use App\Message\UserSelectionMessage;
use App\Trait\ViolationErrorsTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
final readonly class SaveUserMatch
{
    use ViolationErrorsTrait;

    public function __construct(
        private SerializerInterface $serializer,
        private MessageBusInterface $messageBus,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/api/selection_save', name: 'selection', methods: Request::METHOD_POST)]
    public function __invoke(Request $request): JsonResponse
    {
        $selectionData = $this->serializer->deserialize($request->getContent(), UserSelectionInput::class, 'json');
        $this->validator->validate($selectionData);
        // fix validation from 500 to 422 then continue handler
        $this->messageBus->dispatch(new UserSelectionMessage(
            $selectionData->choosingUserId,
            $selectionData->ratedUserId,
            $selectionData->rate,
        ));

        return new JsonResponse('Dispatched message');
    }
}
