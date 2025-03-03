<?php

declare(strict_types=1);

namespace ParcelTrap\Exceptions;

use Exception;
use ParcelTrap\Contracts\Driver;
use ParcelTrap\Contracts\ParcelTrapException;
use Throwable;

abstract class ParcelTrapDriverException extends Exception implements ParcelTrapException
{
    public function __construct(public readonly Driver $driver, string $message = '', int $code = 0, Throwable|null $previous = null)
    {
        parent::__construct(
            message: $message,
            code: $code,
            previous: $previous,
        );
    }

    public function driverName(): string
    {
        return self::getDriverName($this->driver);
    }

    protected static function getDriverName(Driver $driver): string
    {
        $class = get_class($driver);
        $class = str_contains($class, '\\') ? substr($class, strrpos($class, '\\') + 1) : $class;

        return str_replace(['ParcelTrap', 'Driver'], '', $class);
    }
}
