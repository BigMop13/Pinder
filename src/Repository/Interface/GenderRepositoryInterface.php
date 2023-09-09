<?php

declare(strict_types=1);

namespace App\Repository\Interface;

interface GenderRepositoryInterface
{
    public function getHobbiesFromArrayOfIds(array $genderIds): array;
}
