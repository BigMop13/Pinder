<?php
declare(strict_types=1);

namespace App\Repository\Interface;

interface HobbyRepositoryInterface
{
    public function getHobbiesFromArrayOfIds(array $hobbyIds): array;
}
