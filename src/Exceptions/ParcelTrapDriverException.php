<?php

namespace ParcelTrap\Exceptions;

use Exception;
use ParcelTrap\Contracts\Driver;

abstract class ParcelTrapDriverException extends Exception
{
    private Driver $driver;

    public function getDriverName(): string
    {
        $class = get_class($this->getDriver());
        $class = str_contains($class, '\\') ? substr($class, strrpos($class, '\\') + 1) : $class;
        $class = str_replace(['ParcelTrap', 'Driver'], '', $class);

        return $class;
    }

    public function getDriver(): Driver
    {
        return $this->driver;
    }

    public function setDriver(Driver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }
}
