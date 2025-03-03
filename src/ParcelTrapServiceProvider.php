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
        $this->app->singleton(ParcelTrap::class);
        $this->app->alias(ParcelTrap::class, Factory::class);

        $this->app->bind(Driver::class, function (Container $app) {
            return $app->make(Factory::class)->driver();
        });
    }
}
