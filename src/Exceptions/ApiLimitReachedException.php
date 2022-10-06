<?php

namespace ParcelTrap\Exceptions;

use ParcelTrap\Contracts\Driver;
use Throwable;

class ApiLimitReachedException extends ParcelTrapDriverException
{
    public function __construct(
        private readonly int $limit,
        private readonly string $period,
        Driver $driver,
        ?Throwable $previous = null
    ) {
        $this->setDriver($driver);

        parent::__construct(
            message: sprintf(
                '%s API limit reached (%d calls/%s)',
                $this->getDriverName(),
                $limit,
                $period
            ),
            code: 429,
            previous: $previous,
        );
    }

    public static function create(int $limit, string $period, Driver $driver, ?Throwable $previous = null): self
    {
        return new self(
            limit: $limit,
            period: $period,
            driver: $driver,
            previous: $previous,
        );
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getPeriod(): string
    {
        return $this->period;
    }
}
