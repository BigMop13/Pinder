<?php

namespace App\Repository\Interface;

interface GenderRepositoryInterface
{
    public function getHobbiesFromArrayOfIds(array $genderIds): array;
}
