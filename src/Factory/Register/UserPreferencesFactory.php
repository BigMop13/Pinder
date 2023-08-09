<?php

declare(strict_types=1);

namespace App\Factory\Register;

use App\Entity\Gender;
use App\Entity\UserPreference;

class UserPreferencesFactory
{
    public static function create(Gender $gender, int $lowerAgeRange, int $upperAgeRange, int $radiusDistance, mixed $hobbies): UserPreference
    {
        return (new UserPreference())
            ->setSex($gender)
            ->setLowerAgeRange($lowerAgeRange)
            ->setUpperAgeRange($upperAgeRange)
            ->setRadiusDistance($radiusDistance)
            ->setHobbies($hobbies);
    }
}
