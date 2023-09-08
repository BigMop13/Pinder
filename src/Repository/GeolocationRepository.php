<?php
declare(strict_types=1);

namespace App\Repository;

use App\Dto\Registration\GeolocationCoordinatesOutput;
use App\Repository\Clients\RedisClient;
use App\Repository\Interface\GeolocationRepositoryInterface;

class GeolocationRepository implements GeolocationRepositoryInterface
{
    private const CITIES_REDIS_KEY = 'CITY';

    public function __construct(private readonly RedisClient $client)
    {
    }

    public function saveNewGeolocation(string $cityName, GeolocationCoordinatesOutput $coordinates): void
    {
        $this->client->getRedisClient()->geoadd(
            self::CITIES_REDIS_KEY,
            $coordinates->lat,
            $coordinates->lon,
            $cityName
        );
    }

    public function getGeolocationByCity(string $cityName): array
    {
        // TODO: Implement getGeolocationByCity() method.
    }
}