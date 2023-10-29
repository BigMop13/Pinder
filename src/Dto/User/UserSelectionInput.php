<?php

declare(strict_types=1);

namespace App\Dto\User;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UserSelectionInput
{
    public function __construct(
        #[Assert\NotBlank()]
        #[Assert\Positive()]
        #[Assert\Type('int')]
        public int $choosingUserId,
        #[Assert\NotBlank()]
        #[Assert\Positive()]
        #[Assert\Type('int')]
        public int $ratedUserId,
        #[Assert\NotBlank]
        #[Assert\Type('bool')]
        public bool $rate,
    ) {
    }
}
