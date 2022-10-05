<?php

declare(strict_types=1);

namespace ParcelTrap\Tests;

use ParcelTrap\Facades\ParcelTrap;
use ParcelTrap\ParcelTrapServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [ParcelTrapServiceProvider::class];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'ParcelTrap' => ParcelTrap::class,
        ];
    }
}
