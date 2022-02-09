<?php

namespace ParcelTrap\Contracts;

use ParcelTrap\DTOs\TrackingDetails;

interface Driver
{
    /** @param  array<string, mixed>  $parameters */
    public function findTrackingDetails(string $identifier, array $parameters = []): TrackingDetails;
}
