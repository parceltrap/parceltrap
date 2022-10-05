<?php

declare(strict_types=1);

namespace ParcelTrap;

use Illuminate\Contracts\Container\Container;
use ParcelTrap\Contracts\Driver;
use ParcelTrap\Contracts\Factory;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ParcelTrapServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('parceltrap')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->bind(Factory::class, ParcelTrap::class);

        $this->app->bind(Driver::class, function (Container $app) {
            return $app->make(Factory::class)->driver(); // @phpstan-ignore-line
        });
    }
}
