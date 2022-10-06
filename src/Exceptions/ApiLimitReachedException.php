<?php

namespace ParcelTrap\Exceptions;

use Exception;
use Throwable;

class ApiLimitReachedException extends Exception
{
    public function __construct(private readonly int $limit, private readonly string $period, ?Throwable $previous = null)
    {
        $message = sprintf('Tracking API limit reached (%d calls/%s)', $limit, $period);

        parent::__construct(
            message: $message,
            code: 429,
            previous: $previous,
        );
    }

    public static function create(int $limit, string $period, ?Throwable $previous = null): self
    {
        return new self(
            limit: $limit,
            period: $period,
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
