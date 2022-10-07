<?php

namespace ParcelTrap\Exceptions;

use Exception;
use ParcelTrap\Contracts\Driver;

abstract class ParcelTrapDriverException extends Exception
{
    public readonly Driver $driver; // @phpstan-ignore-line

    public function getDriverName(): string
    {
        $class = get_class($this->driver);
        $class = str_contains($class, '\\') ? substr($class, strrpos($class, '\\') + 1) : $class;
        $class = str_replace(['ParcelTrap', 'Driver'], '', $class);

        return $class;
    }
}
