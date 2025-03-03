<?php

declare(strict_types=1);

namespace ParcelTrap\Drivers;

use DateTimeImmutable;
use ParcelTrap\Contracts\Driver;
use ParcelTrap\DTOs\TrackingDetails;
use ParcelTrap\Enums\Status;
use ParcelTrap\Exceptions\ApiAuthenticationFailedException;
use ParcelTrap\Exceptions\ApiLimitReachedException;

class NullDriver implements Driver
{
    public function find(string $identifier, array $parameters = []): TrackingDetails
    {
        if ($identifier === 'MOCK-AUTHENTICATION-FAILED') {
            throw new ApiAuthenticationFailedException(
                driver: $this,
            );
        }

        if ($identifier === 'MOCK-API-LIMIT-EXCEEDED') {
            throw new ApiLimitReachedException(
                driver: $this,
                limit: 10,
                period: 'minute',
            );
        }

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
