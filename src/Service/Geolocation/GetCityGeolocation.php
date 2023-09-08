<?php
declare(strict_types=1);

namespace App\Service\Geolocation;

use App\Dto\Registration\GeolocationCoordinatesOutput;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

readonly class GetCityGeolocation
{
    public function __construct(private string $geolocationApiUrl, private SerializerInterface $serializer)
    {

    }

    public function getGeolocationFromCityName(string $cityName): GeolocationCoordinatesOutput
    {
        $client = new Client();
        $response = $client->request(
            Request::METHOD_GET,
            $this->geolocationApiUrl.$cityName
        );

        $firstResponse = json_encode(json_decode($response->getBody()->getContents(), true)[0]);

        return $this->serializer->deserialize($firstResponse, GeolocationCoordinatesOutput::class, 'json');
    }
}