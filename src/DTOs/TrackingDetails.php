<?php

declare(strict_types=1);

namespace ParcelTrap\DTOs;

use DateTimeImmutable;
use ParcelTrap\Enums\Status;
use Spatie\LaravelData\Data;

class TrackingDetails extends Data
{
    public function __construct(
        public string $identifier,
        public string|null $summary,
        public DateTimeImmutable|null $estimatedDelivery,
        public Status $status,
        /** @var list<array> $events */
        public array $events,
        /** @var array<string, mixed> $raw */
        public array $raw,
    ) {}
}
