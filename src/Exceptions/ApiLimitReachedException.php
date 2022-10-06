<?php

namespace ParcelTrap\Exceptions;

use Exception;
use Throwable;

class ApiLimitReachedException extends Exception
{
    public function __construct(private readonly int $limit, private readonly ?string $period = null, ?Throwable $previous = null)
    {
        $message = sprintf(
            'Tracking API limit reached (%d calls%s)',
            $limit,
            ($period !== null) ? ('/' . $period) : '',
        );

        parent::__construct(
            message: $message,
            code: 429,
            previous: $previous,
        );
    }

    public static function create(int $limit, ?string $period = null, ?Throwable $previous = null): self
    {
        return new self(
            limit: $limit,
            period: $period,
            previous: $previous,
        );
    }
}
