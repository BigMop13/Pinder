<?php

declare(strict_types=1);

namespace App\Dto\Registration;

final readonly class RegistrationInput
{
    public function __construct(
        public string $uid,
        public string $username,
        public ?array $roles,
        public int $genderId,
        public int $age,
        public string $address,
        public UserPreferenceInput $userPreference,
        public UserDetailsInput $userDetails
    ) {
    }
}
