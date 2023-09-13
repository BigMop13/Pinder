<?php

declare(strict_types=1);

namespace App\Factory\Register;

use App\Entity\UserDetails;

class UserDetailsFactory
{
    public static function create(string $description, string $education, string $work, mixed $images, mixed $hobbies): UserDetails
    {
        return (new UserDetails())
            ->setDescription($description)
            ->setEducation($education)
            ->setWork($work)
            ->setImages($images)
            ->setHobbies($hobbies);
    }
}
