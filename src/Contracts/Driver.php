<?php

namespace ParcelTrap\Contracts;

use ParcelTrap\DTOs\TrackingDetails;
use ParcelTrap\Exceptions\ApiLimitReachedException;

interface Driver
{
    /**
     * @param  array<string, mixed>  $parameters
     * @throws ApiLimitReachedException
     */
    public function find(string $identifier, array $parameters = []): TrackingDetails;
}
