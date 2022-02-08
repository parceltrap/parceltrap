<?php

declare(strict_types=1);

namespace OwenVoke\ParcelTrap\DTOs;

use DateTime;
use OwenVoke\ParcelTrap\Enums\Status;

class TrackingDetails
{
    public string $identifier;
    public ?string $summary;
    public ?DateTime $estimatedDelivery;
    public Status $status;
    /** @var array<int, array> */
    public array $events;
    /** @var array<string, mixed> */
    public array $raw;

    public function __construct(
        string $identifier,
        Status $status,
        ?string $summary = null,
        ?DateTime $estimatedDelivery = null,
        array $events = [],
        array $raw = []
    ) {
        $this->identifier = $identifier;
        $this->status = $status;
        $this->summary = $summary;
        $this->estimatedDelivery = $estimatedDelivery;
        $this->events = $events;
        $this->raw = $raw;
    }
}
