<?php

declare(strict_types=1);

namespace App\Dto\Registration;

use Symfony\Component\Serializer\Annotation\SerializedName;
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
        #[SerializedName('gender')]
        public int $genderId,
        public \DateTime $age,
        #[Assert\NotBlank()]
        #[Assert\Length(
            min: 3,
        )]
        public string $address,
        #[Assert\Valid]
        #[SerializedName('userPreferences')]
        public UserPreferenceInput $userPreference,
        #[Assert\Valid]
        public UserDetailsInput $userDetails,
    ) {
    }
}
