<?php

namespace ParcelTrap\Tests;

use DateTimeImmutable;
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
            summary: 'This is a summary for the null driver',
            estimatedDelivery: new DateTimeImmutable('2022-01-01'),
            status: Status::Unknown,
            events: [],
            raw: [],
        );
    }
}
