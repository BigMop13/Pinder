<?php

declare(strict_types=1);

namespace App\Factory\Register;

use App\Entity\UserPreference;
use Doctrine\Common\Collections\Collection;

class UserPreferencesFactory
{
    public static function create(int $lowerAgeRange, int $upperAgeRange, int $radiusDistance, Collection $hobbies, Collection $genders): UserPreference
    {
        return (new UserPreference())
            ->setLowerAgeRange($lowerAgeRange)
            ->setUpperAgeRange($upperAgeRange)
            ->setRadiusDistance($radiusDistance)
            ->setHobbies($hobbies)
            ->setGenders($genders);
    }
}
