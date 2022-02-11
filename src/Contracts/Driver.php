<?php

namespace ParcelTrap\Contracts;

use GuzzleHttp\ClientInterface;
use ParcelTrap\DTOs\TrackingDetails;

interface Driver
{
    /** @param array<string, mixed> $config */
    public static function make(array $config, ?ClientInterface $client = null): self;

    /** @param  array<string, mixed>  $parameters */
    public function find(string $identifier, array $parameters = []): TrackingDetails;
}
