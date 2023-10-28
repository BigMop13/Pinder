<?php

declare(strict_types=1);

namespace App\Dto\User;

final readonly class UserSelection
{
    public function __construct(
        public int $choosingUserId,
        public int $ratedUserId,
        public bool $rate,
    ) {
    }
}
