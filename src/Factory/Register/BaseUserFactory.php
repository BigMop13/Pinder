<?php

declare(strict_types=1);

namespace App\Factory\Register;

use App\Entity\Gender;
use App\Entity\User;

class BaseUserFactory
{
    public static function create(string $uid, string $username, array $roles, Gender $gender, int $age, string $address): User
    {
        return (new User())
            ->setUid($uid)
            ->setUsername($username)
            ->setRoles($roles)
            ->setSex($gender)
            ->setAge($age)
            ->setAddress($address);
    }
}
