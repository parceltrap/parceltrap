<?php

namespace ParcelTrap\Contracts;

use ParcelTrap\DTOs\TrackingDetails;
use ParcelTrap\Exceptions\ApiLimitReachedException;
use ParcelTrap\Exceptions\ApiAuthenticationFailedException;

interface Driver
{
    /**
     * @param  array<string, mixed>  $parameters
     * @throws ApiAuthenticationFailedException
     * @throws ApiLimitReachedException
     */
    public function find(string $identifier, array $parameters = []): TrackingDetails;
}
