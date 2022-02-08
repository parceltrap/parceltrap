<?php

namespace OwenVoke\ParcelTrap\DTOs;

use DateTime;

class TrackingDetails
{
    public string $identifier;
    public ?string $summary;
    public ?DateTime $estimatedDelivery;
    public Status $status;
    /** @var array<int, array> */
    public array $events;
    /** @var array<string, mixed> */
    public array $extras;
}
