<?php

namespace App\Repository\Interface;

interface HobbyRepositoryInterface
{
    public function getHobbiesFromArrayOfIds(array $hobbyIds): array;
}
