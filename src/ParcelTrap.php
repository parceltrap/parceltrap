<?php

declare(strict_types=1);

namespace ParcelTrap;

use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Manager;
use InvalidArgumentException;
use ParcelTrap\Contracts\Factory;
use ParcelTrap\Contracts\Driver;
use ParcelTrap\Drivers\NullDriver;

class ParcelTrap extends Manager implements Factory
{
    private ?string $default = null;

    /** @param  array<string, Driver>  $drivers */
    public static function make(array $drivers = null): self
    {
        $container = new Container();

        $container->bind(Repository::class, \Illuminate\Config\Repository::class);
        $container->alias(Repository::class, 'config');

        return new self(tap($container, function (Container $container) use ($drivers) {
            foreach ($drivers as $name => $driver) {
                $container->bind($name, fn() => $driver);
            }
        }));
    }

    public function createNullDriver(): NullDriver
    {
        return new NullDriver();
    }

    public function getDefaultDriver(): string
    {
        if ($this->default === null) {
            throw new InvalidArgumentException('No default driver has been configured');
        }

        return $this->default;
    }

    public function setDefaultDriver(string $name): void
    {
        $this->default = $name;
    }
}
