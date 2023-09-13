<?php

declare(strict_types=1);

namespace App\Dto\Registration;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UserDetailsInput
{
    public function __construct(
        #[Assert\NotBlank()]
        #[Assert\Length(
            min: 50,
            max: 250,
        )]
        public string $description,
        public string $education,
        public string $work,
        /**
         * @var string[] $imageUrls
         */
        #[Assert\Count(min: 1)]
        public array $imageUrls,
        #[Assert\Count(min: 3)]
        public array $hobbyIds
    ) {
    }
}
