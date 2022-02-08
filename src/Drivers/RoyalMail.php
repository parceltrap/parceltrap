<?php

declare(strict_types=1);

namespace OwenVoke\ParcelTrap\Drivers;

use DateTimeImmutable;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use OwenVoke\ParcelTrap\Contracts\Driver;
use OwenVoke\ParcelTrap\DTOs\TrackingDetails;
use OwenVoke\ParcelTrap\Enums\Status;

class RoyalMail implements Driver
{
    private Client $client;

    public function __construct(string $clientId, string $clientSecret, bool $acceptTerms = true)
    {
        $this->client = new Client([
            'base_uri' => 'https://api.royalmail.net',
            RequestOptions::HEADERS => [
                'X-Accept-RMG-Terms' => $acceptTerms ? 'yes' : 'no',
                'X-IBM-Client-Id' => $clientId,
                'X-IBM-Client-Secret' => $clientSecret,
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function findTrackingDetails(string $identifier, array $parameters = []): TrackingDetails
    {
        $request = $this->client->get("/mailpieces/v2/{$identifier}/events", [
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
        return match($status) {
            'IN TRANSIT' => Status::IN_TRANSIT,
            'DELIVERED' => Status::DELIVERED,
            default => Status::UNKNOWN,
        };
    }
}
