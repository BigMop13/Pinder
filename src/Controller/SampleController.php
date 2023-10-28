<?php

declare(strict_types=1);

namespace App\Controller;

use App\Message\SampleMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class SampleController extends AbstractController
{
    #[Route('/api/sample', name: 'sample', methods: Request::METHOD_GET)]
    public function sampleMessageEndpoint(MessageBusInterface $bus): JsonResponse
    {
        $message = new SampleMessage('test message');
        $bus->dispatch($message);

        return new JsonResponse(sprintf('Message with content: %s was published', $message->getContent()));
    }
}
