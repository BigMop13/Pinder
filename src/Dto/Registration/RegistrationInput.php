<?php

declare(strict_types=1);

namespace App\Dto\Registration;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class RegistrationInput
{
    public function __construct(
        #[Assert\NotBlank()]
        public string $uid,
        #[Assert\NotBlank()]
        #[Assert\Length(
            min: 3,
            max: 99,
        )]
        public string $username,
        public ?array $roles,
        public int $genderId,
        #[Assert\GreaterThanOrEqual(18)]
        #[Assert\LessThanOrEqual(99)]
        public int $age,
        #[Assert\NotBlank()]
        #[Assert\Length(
            min: 3,
        )]
        public string $address,
        #[Assert\Valid]
        public UserPreferenceInput $userPreference,
        #[Assert\Valid]
        public UserDetailsInput $userDetails,
    ) {
    }
}
