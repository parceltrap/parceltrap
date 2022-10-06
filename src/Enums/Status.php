<?php

declare(strict_types=1);

namespace ParcelTrap\Enums;

enum Status: string
{
    case Pending = 'pending';
    case Pre_Transit = 'pre_transit';
    case In_Transit = 'in_transit';
    case Delivered = 'delivered';
    case Failure = 'failure';
    case Not_Found = 'not_found';
    case Unknown = 'unknown';
    case Cancelled = 'cancelled';

    public function description(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Pre_Transit => 'Pre-Transit',
            self::In_Transit => 'In Transit',
            self::Delivered => 'Delivered',
            self::Failure => 'Failure',
            self::Not_Found => 'Not Found',
            self::Unknown => 'Unknown',
            self::Cancelled => 'Cancelled',
        };
    }
}
