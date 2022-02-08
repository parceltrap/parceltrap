<?php

namespace OwenVoke\ParcelTrap\Drivers;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use OwenVoke\ParcelTrap\Contracts\Driver;
use OwenVoke\ParcelTrap\DTOs\TrackingDetails;
use Status;

class DHL implements Driver
{

    private Client $client;

    public function __construct(string $clientId)
    {
        $this->client = new Client([
            'base_uri' => 'https://api-eu.dhl.com',
            RequestOptions::HEADERS => [
                'DHL-API-Key' => $clientId,
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function findTrackingDetails(string $identifier, array $parameters = []): TrackingDetails
    {
        $request = $this->client->get('/track/shipments', [
            RequestOptions::QUERY => array_merge([
                'trackingNumber' => $identifier,
            ], $parameters),
        ]);

        $json = json_decode($request->getBody(), true, 512, JSON_THROW_ON_ERROR);

        assert(isset($json['shipments'][0]), 'No shipment could be found with this id');
        assert(count($json['shipments']) === 1, 'One or more shipments exist with this id, please try again with additional filters');

        $json = $json['shipments'][0];
        assert(isset($json['status']['statusCode']), 'The status is missing from the response');
        assert(isset($json['status']['description']), 'The summary is missing from the response');
        assert(isset($json['events']), 'The events array is missing from the response');

        return new TrackingDetails(
            identifier: $json['mailPieces']['mailPieceId'],
            status: $this->mapStatus($json['status']['statusCode']),
            summary: $json['status']['remark'] ?? $json['status']['description'],
            estimatedDelivery: isset($json['estimatedTimeOfDelivery']) ? new DateTime($json['estimatedTimeOfDelivery']) : null,
            events: $json['events'],
            raw: $json,
        );
    }

    private function mapStatus(string $status): Status
    {
        return match($status) {
            'pre-transit' => Status::PRE_TRANSIT,
            'transit' => Status::IN_TRANSIT,
            'delivered' => Status::DELIVERED,
            'failure' => Status::FAILURE,
            default => Status::UNKNOWN,
        };
    }
}
