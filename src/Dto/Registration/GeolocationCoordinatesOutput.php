<?php

declare(strict_types=1);

namespace App\Dto\Registration;

final readonly class GeolocationCoordinatesOutput
{
    public function __construct(
        public string $cityName,
        public string $lat,
        public string $lon
    ) {
    }
}
