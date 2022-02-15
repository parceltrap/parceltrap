<?php

declare(strict_types=1);

namespace ParcelTrap;

use InvalidArgumentException;
use ParcelTrap\Contracts\Driver;

/** @mixin Driver */
class ParcelTrap
{
    /** @var array<string, Driver> */
    private array $drivers;

    private ?string $default = null;

    /** @param array<string, Driver> $drivers */
    public function __construct(array $drivers)
    {
        foreach ($drivers as $name => $driver) {
            $this->addDriver($name, $driver);
        }
    }

    /** @param array<string, Driver> $drivers */
    public static function make(array $drivers = []): self
    {
        return new self($drivers);
    }

    public function driver(string $name = null): Driver
    {
        if ($name === null) {
            $name = $this->getDefaultDriver();
        }

        if (! isset($this->drivers[$name])) {
            throw new InvalidArgumentException('The specified driver could not be found');
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
        if ($this->default === null) {
            throw new InvalidArgumentException('No default driver has been configured');
        }

        return $this->default;
    }

    public function setDefaultDriver(string $name): void
    {
        if (! isset($this->drivers[$name])) {
            throw new InvalidArgumentException('The specified default driver could not be found in the list of drivers');
        }

        $this->default = $name;
    }

    public function __call(string $name, array $arguments): mixed
    {
        return $this->driver()->{$name}(...$arguments);
    }
}
