<?php

declare(strict_types=1);

namespace ParcelTrap\DTOs;

use DateTimeImmutable;
use ParcelTrap\Enums\Status;
use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
class TrackingDetails extends DataTransferObject
{
    public string $identifier;

    public ?string $summary;

    public ?DateTimeImmutable $estimatedDelivery;

    public Status $status;

    /** @var array<int, array> */
    public array $events;

    /** @var array<string, mixed> */
    public array $raw;
}
