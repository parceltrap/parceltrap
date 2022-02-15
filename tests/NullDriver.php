<?php

namespace ParcelTrap\Tests;

use GuzzleHttp\ClientInterface;
use ParcelTrap\Contracts\Driver;
use ParcelTrap\DTOs\TrackingDetails;
use ParcelTrap\Enums\Status;

class NullDriver implements Driver
{
    public static function make(array $config, ?ClientInterface $client = null): Driver
    {
        return new self();
    }

    public function find(string $identifier, array $parameters = []): TrackingDetails
    {
        return new TrackingDetails(
            identifier: $identifier,
            summary: '',
            estimatedDelivery: new \DateTimeImmutable(),
            status: Status::Unknown,
            events: [],
            raw: [],
        );
    }
}
