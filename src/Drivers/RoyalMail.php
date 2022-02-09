<?php

declare(strict_types=1);

namespace OwenVoke\ParcelTrap\Drivers;

use DateTimeImmutable;
use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use OwenVoke\ParcelTrap\Contracts\Driver;
use OwenVoke\ParcelTrap\DTOs\TrackingDetails;
use OwenVoke\ParcelTrap\Enums\Status;

class RoyalMail implements Driver
{
    public const BASE_URI = 'https://api.royalmail.net';
    private ClientInterface $client;

    public function __construct(private string $clientId, private string $clientSecret, private bool $acceptTerms = true, ?ClientInterface $client = null)
    {
        $this->client = $client ?? GuzzleFactory::make(['base_uri' => self::BASE_URI]);
    }

    public function findTrackingDetails(string $identifier, array $parameters = []): TrackingDetails
    {
        $request = $this->client->request('GET', "/mailpieces/v2/{$identifier}/events", [
            RequestOptions::HEADERS => $this->getHeaders(),
            RequestOptions::QUERY => $parameters,
        ]);

        /** @var array $json */
        $json = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        assert(isset($json['mailPieces']), 'No shipment could be found with this id');
        $json = $json['mailPieces'];

        assert(isset($json['mailPieceId']), 'The identifier is missing from the response');
        assert(isset($json['summary']['statusCategory']), 'The status is missing from the response');
        assert(isset($json['summary']['summaryLine']), 'The summary is missing from the response');
        assert(isset($json['estimatedDelivery']['date']), 'The estimated delivery date is missing from the response');
        assert(isset($json['events']), 'The events array is missing from the response');

        return new TrackingDetails(
            identifier: $json['mailPieceId'],
            status: $this->mapStatus($json['summary']['statusCategory']),
            summary: $json['summary']['summaryLine'],
            estimatedDelivery: new DateTimeImmutable($json['estimatedDelivery']['date']),
            events: $json['events'],
            raw: $json,
        );
    }

    private function mapStatus(string $status): Status
    {
        return match ($status) {
            'IN TRANSIT' => Status::IN_TRANSIT,
            'DELIVERED' => Status::DELIVERED,
            default => Status::UNKNOWN,
        };
    }

    /**
     * @param  array<string, mixed>  $headers
     * @return array<string, mixed>
     */
    private function getHeaders(array $headers = []): array
    {
        return array_merge([
            'X-Accept-RMG-Terms' => $this->acceptTerms ? 'yes' : 'no',
            'X-IBM-Client-Id' => $this->clientId,
            'X-IBM-Client-Secret' => $this->clientSecret,
            'Accept' => 'application/json',
        ], $headers);
    }
}
