<?php

namespace ParcelTrap\Exceptions;

use ParcelTrap\Contracts\Driver;
use Throwable;

class ApiLimitReachedException extends ParcelTrapDriverException
{
    public function __construct(
        public readonly Driver $driver,
        public readonly int $limit,
        public readonly string $period,
        ?Throwable $previous = null
    ) {
        parent::__construct(
            message: sprintf(
                'The API limit of %s requests per %s has been reached for the %s driver',
                $limit,
                $period,
                $this->getDriverName(),
            ),
            code: 429,
            previous: $previous,
        );
    }

    public static function create(Driver $driver, int $limit, string $period, ?Throwable $previous = null): self
    {
        return new self(
            driver: $driver,
            limit: $limit,
            period: $period,
            previous: $previous,
        );
    }
}
