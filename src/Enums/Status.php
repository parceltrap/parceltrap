<?php

declare(strict_types=1);

namespace ParcelTrap\Enums;

enum Status: string
{
    case Pre_Transit = 'pre_transit';
    case In_Transit = 'in_transit';
    case Delivered = 'delivered';
    case Failure = 'failure';
    case Unknown = 'unknown';

    public function description(): string
    {
        return match($this) {
            self::Pre_Transit => 'Pre-Transit',
            self::In_Transit => 'In Transit',
            self::Delivered => 'Delivered',
            self::Failure => 'Failure',
            self::Unknown => 'Unknown',
        };
    }
}
