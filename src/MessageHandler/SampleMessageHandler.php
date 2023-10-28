<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SampleMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SampleMessageHandler
{
    public function __invoke(SampleMessage $message): void
    {
        print_r('Handled message!');
    }
}
