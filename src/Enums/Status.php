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
}
