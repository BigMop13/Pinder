<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\UserSelectionMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UserSelectionMessageHandler
{
    public function __construct()
    {
    }

    public function __invoke(UserSelectionMessage $message): void
    {
    }
}
