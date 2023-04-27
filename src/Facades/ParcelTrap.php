<?php

declare(strict_types=1);

namespace ParcelTrap\Facades;

use Illuminate\Support\Facades\Facade;
use ParcelTrap\Contracts\Driver;
use ParcelTrap\DTOs\TrackingDetails;

/**
 * @method static Driver driver(string|null $driver = null)
 * @method static TrackingDetails find(string $identifier, array $parameters = [])
 */
class ParcelTrap extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ParcelTrap\ParcelTrap::class;
    }
}
