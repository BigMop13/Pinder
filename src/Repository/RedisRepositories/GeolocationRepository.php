<?php

declare(strict_types=1);

namespace App\Repository\RedisRepositories;

use App\Dto\Registration\GeolocationCoordinatesOutput;
use App\Repository\Clients\RedisClient;
use App\Repository\Interface\GeolocationRepositoryInterface;

class GeolocationRepository implements GeolocationRepositoryInterface
{
    private const CITIES_REDIS_KEY = 'CITY';
    private const DISTANCE_UNIT = 'km';

    public function __construct(private readonly RedisClient $client)
    {
    }

    public function saveNewGeolocation(GeolocationCoordinatesOutput $coordinates): void
    {
        $this->client->getRedisClient()->geoadd(
            self::CITIES_REDIS_KEY,
            $coordinates->lat,
            $coordinates->lon,
            $coordinates->cityName
        );
    }

    /**
     * @return string[]|null
     */
    public function getGeolocationByCity(string $cityName): ?array
    {
        return $this->client->getRedisClient()->geopos(self::CITIES_REDIS_KEY, (array) $cityName)[0];
    }

    /**
     * @return string[]
     */
    public function getAllCitiesInRadius(int $radius, string $cityName): array
    {
        return $this->client->getRedisClient()->georadiusbymember(self::CITIES_REDIS_KEY, $cityName, $radius, self::DISTANCE_UNIT);
    }
}
