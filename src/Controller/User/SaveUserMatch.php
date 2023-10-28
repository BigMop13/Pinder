<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Dto\User\UserSelection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final readonly class SaveUserMatch
{
    public function __construct(
        private SerializerInterface $serializer,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $selectionData = $this->serializer->deserialize($request->getContent(), UserSelection::class, 'json');
        // create event and dispatch it
    }
}
