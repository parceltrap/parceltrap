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

class DHL implements Driver
{
    public const BASE_URI = 'https://api-eu.dhl.com';
    private ClientInterface $client;

    public function __construct(private string $clientId, ?ClientInterface $client = null)
    {
        $this->client = $client ?? GuzzleFactory::make(['base_uri' => self::BASE_URI]);
    }

    public function findTrackingDetails(string $identifier, array $parameters = []): TrackingDetails
    {
        $request = $this->client->request('GET', '/track/shipments', [
            RequestOptions::HEADERS => $this->getHeaders(),
            RequestOptions::QUERY => array_merge([
                'trackingNumber' => $identifier,
            ], $parameters),
        ]);

        /** @var array $json */
        $json = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        assert(isset($json['shipments'][0]), 'No shipment could be found with this id');
        assert(
            count($json['shipments']) === 1,
            'One or more shipments exist with this id, please try again with additional filters'
        );

        $json = $json['shipments'][0];
        assert(isset($json['status']['statusCode']), 'The status is missing from the response');
        assert(isset($json['status']['description']), 'The summary is missing from the response');
        assert(isset($json['events']), 'The events array is missing from the response');

        return new TrackingDetails(
            identifier: $json['mailPieces']['mailPieceId'],
            status: $this->mapStatus($json['status']['statusCode']),
            summary: $json['status']['remark'] ?? $json['status']['description'],
            estimatedDelivery: isset($json['estimatedTimeOfDelivery']) ? new DateTimeImmutable($json['estimatedTimeOfDelivery']) : null,
            events: $json['events'],
            raw: $json,
        );
    }

    private function mapStatus(string $status): Status
    {
        return match ($status) {
            'pre-transit' => Status::Pre_Transit,
            'transit' => Status::In_Transit,
            'delivered' => Status::Delivered,
            'failure' => Status::Failure,
            default => Status::Unknown,
        };
    }

    /**
     * @param  array<string, mixed>  $headers
     * @return array<string, mixed>
     */
    private function getHeaders(array $headers = []): array
    {
        return array_merge([
            'DHL-API-Key' => $this->clientId,
            'Accept' => 'application/json',
        ], $headers);
    }
}
