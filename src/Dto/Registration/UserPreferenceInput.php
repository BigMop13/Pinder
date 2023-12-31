<?php

declare(strict_types=1);

namespace App\Dto\Registration;

use App\Validator\Constraints\UpperAgeGreaterThanLower;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[UpperAgeGreaterThanLower]
final readonly class UserPreferenceInput
{
    public function __construct(
        #[Assert\GreaterThanOrEqual(18)]
        public int $lowerAgeRange,
        #[Assert\GreaterThanOrEqual(18)]
        #[Assert\LessThanOrEqual(99)]
        public int $upperAgeRange,
        #[Assert\Positive()]
        #[Assert\LessThanOrEqual(300)]
        public int $radiusDistance,
        /* @var int[] $hobbyIds */
        #[Assert\Count(min: 3)]
        #[SerializedName('hobbies')]
        public array $hobbyIds,
        /* @var int[] $genderIds */
        #[Assert\Count(min: 1)]
        #[SerializedName('genders')]
        public array $genderIds,
    ) {
    }
}
