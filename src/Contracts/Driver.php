<?php

declare(strict_types=1);

namespace ParcelTrap\Contracts;

use ParcelTrap\DTOs\TrackingDetails;
use ParcelTrap\Exceptions\ApiAuthenticationFailedException;
use ParcelTrap\Exceptions\ApiLimitReachedException;

interface Driver
{
    /**
     * @param  array<string, mixed>  $parameters
     *
     * @throws ApiAuthenticationFailedException
     * @throws ApiLimitReachedException
     */
    public function find(string $identifier, array $parameters = []): TrackingDetails;
}
