<?php

declare(strict_types=1);

namespace ParcelTrap;

use ParcelTrap\Contracts\Driver;

final class ParcelTrap
{
    /** @var array<string, Driver> */
    private array $drivers;

    private string $default;

    /** @param array<string, Driver> $drivers */
    public function __construct(array $drivers)
    {
        foreach ($drivers as $name => $driver) {
            $this->addDriver($name, $driver);
        }
    }

    public function driver(string $name = null): Driver
    {
        if ($name === null) {
            $name = $this->getDefaultDriver();
        }

        return $this->drivers[$name];
    }

    public function addDriver(string $name, Driver $driver): void
    {
        $this->drivers[$name] = $driver;
    }

    public function hasDriver(string $name): bool
    {
        return isset($this->drivers[$name]);
    }

    public function getDefaultDriver(): string
    {
        return $this->default;
    }

    public function setDefaultDriver(string $name): void
    {
        $this->default = $name;
    }
}
