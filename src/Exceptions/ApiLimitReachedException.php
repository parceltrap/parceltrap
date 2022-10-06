<?php

namespace ParcelTrap\Exceptions;

use Exception;
use ParcelTrap\Contracts\Driver;
use Throwable;

class ApiLimitReachedException extends Exception
{
    public function __construct(private Driver $driver, private readonly int $limit, private readonly string $period, ?Throwable $previous = null)
    {
        $message = sprintf(
            '%s API limit reached (%d calls/%s)',
            static::getDriverName($driver),
            $limit,
            $period
        );

        parent::__construct(
            message: $message,
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

    private static function getDriverName(Driver $driver): string
    {
        $class = basename(get_class($driver));
        $class = str_replace(['ParcelTrap', 'Driver'], '', $class);

        return $class;
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
