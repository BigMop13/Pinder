<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Dto\Registration\GeolocationCoordinatesOutput;

interface GeolocationRepositoryInterface
{
    public function saveNewGeolocation(GeolocationCoordinatesOutput $coordinates): void;

    public function getGeolocationByCity(string $cityName): ?array;
}
