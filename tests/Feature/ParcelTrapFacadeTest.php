<?php

declare(strict_types=1);

use ParcelTrap\DTOs\TrackingDetails;
use ParcelTrap\Facades\ParcelTrap;

it('can call methods via the ParcelTrap facade', function () {
    expect(ParcelTrap::find('ABCDEFG'))
        ->toBeInstanceOf(TrackingDetails::class)
        ->identifier->toBe('ABCDEFG')
        ->estimatedDelivery->toEqual(new DateTimeImmutable('2022-01-01'));
});
