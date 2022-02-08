<?php

enum Status: string
{
    case IN_TRANSIT = 'In Transit';
    case DELIVERED = 'Delivered';
    case UNKNOWN = 'Unknown';
}
