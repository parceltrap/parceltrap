<?php

namespace OwenVoke\ParcelTrap\Contracts;

use OwenVoke\ParcelTrap\DTOs\TrackingDetails;

interface Driver
{
    /** @param  array<string, mixed>  $parameters */
    public function findTrackingDetails(string $identifier, array $parameters = []): TrackingDetails;
}
