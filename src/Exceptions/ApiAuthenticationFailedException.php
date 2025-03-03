<?php

declare(strict_types=1);

namespace ParcelTrap\Exceptions;

use ParcelTrap\Contracts\Driver;
use Throwable;

class ApiAuthenticationFailedException extends ParcelTrapDriverException
{
    public function __construct(
        Driver $driver,
        Throwable|null $previous = null
    ) {
        parent::__construct(
            driver: $driver,
            message: sprintf(
                'The API authentication failed for the %s driver',
                self::getDriverName($driver),
            ),
            code: 403,
            previous: $previous,
        );
    }

    public static function create(Driver $driver, Throwable|null $previous = null): self
    {
        return new self(
            driver: $driver,
            previous: $previous,
        );
    }
}
