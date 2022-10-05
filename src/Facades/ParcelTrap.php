<?php

declare(strict_types=1);

namespace ParcelTrap\Facades;

use Illuminate\Support\Facades\Facade;

/** @mixin \ParcelTrap\ParcelTrap */
class ParcelTrap extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ParcelTrap\ParcelTrap::class;
    }
}
