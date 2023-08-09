<?php

declare(strict_types=1);

namespace App\Dto\Registration;

final readonly class UserDetailsInput
{
    public function __construct(
        public string $description,
        public string $education,
        public string $work,
        /**
         * @var string[] $imageUrls
         */
        public array $imageUrls
    ) {
    }
}
