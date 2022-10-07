<?php

namespace ParcelTrap\Exceptions;

use ParcelTrap\Contracts\Driver;
use Throwable;

class ApiAuthenticationFailedException extends ParcelTrapDriverException
{
    public function __construct(
        public readonly Driver $driver,
        ?Throwable $previous = null
    ) {
        parent::__construct(
            message: sprintf(
                'The API authentication failed for the %s driver',
                $this->getDriverName(),
            ),
            code: 403,
            previous: $previous,
        );
    }

    public static function create(Driver $driver, ?Throwable $previous = null): self
    {
        return new self(
            driver: $driver,
            previous: $previous,
        );
    }
}
