<?php

declare(strict_types=1);

namespace OwenVoke\ParcelTrap\Enums;

enum Status: string
{
    case PRE_TRANSIT = 'Pre-Transit';
    case IN_TRANSIT = 'In Transit';
    case DELIVERED = 'Delivered';
    case FAILURE = 'Failure';
    case UNKNOWN = 'Unknown';
}
