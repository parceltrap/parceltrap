<?php

enum Status: string
{
    case PRE_TRANSIT = 'Pre-Transit';
    case IN_TRANSIT = 'In Transit';
    case DELIVERED = 'Delivered';
    case FAILURE = 'Failure';
    case UNKNOWN = 'Unknown';
}
