<?php

declare(strict_types=1);

namespace App\Dto\Registration;

final readonly class UserPreferenceInput
{
    public function __construct(
        public int $genderId,
        public int $lowerAgeRange,
        public int $upperAgeRange,
        public int $radiusDistance,
        /**
         * @var int[] $hobbyIds
         */
        public array $hobbyIds
    ) {
    }
}
