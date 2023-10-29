<?php

declare(strict_types=1);

namespace App\Message;

final readonly class UserSelectionMessage
{
    public function __construct(
        private int $choosingUserId,
        private int $ratedUserId,
        private bool $rate,
    ) {
    }

    public function getChoosingUserId(): int
    {
        return $this->choosingUserId;
    }

    public function getRatedUserId(): int
    {
        return $this->ratedUserId;
    }

    public function isRate(): bool
    {
        return $this->rate;
    }
}
