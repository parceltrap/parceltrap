<?php

namespace ParcelTrap\Exceptions;

use ParcelTrap\Contracts\Driver;
use Throwable;

class ApiAuthenticationFailedException extends ParcelTrapDriverException
{
    public function __construct(
        Driver $driver,
        ?Throwable $previous = null
    ) {
        $this->setDriver($driver);

        parent::__construct(
            message: sprintf(
                'Failed to authenticate connection with %s',
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
