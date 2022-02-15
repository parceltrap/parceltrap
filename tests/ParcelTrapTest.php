<?php

declare(strict_types=1);

use ParcelTrap\DTOs\TrackingDetails;
use ParcelTrap\Enums\Status;
use ParcelTrap\ParcelTrap;
use ParcelTrap\Tests\NullDriver;

it('can instantiate ParcelTrap', function () {
    expect(ParcelTrap::make(['null' => NullDriver::make([])]))
        ->toBeInstanceOf(ParcelTrap::class);
});

it('can retrieve a driver from ParcelTrap', function () {
    expect(ParcelTrap::make(['null' => NullDriver::make([])]))
        ->driver('null')
        ->toBeInstanceOf(NullDriver::class);
});

it('can set a default ParcelTrap driver', function () {
    $client = ParcelTrap::make(['null' => NullDriver::make([])]);
    $client->setDefaultDriver('null');

    expect($client->getDefaultDriver())->toBe('null');
    expect($client->driver())->toBeInstanceOf(NullDriver::class);
});

it('can call `find` on a ParcelTrap driver', function () {
    expect(ParcelTrap::make(['null' => NullDriver::make([])])->driver('null')->find('abcdefg'))
        ->toBeInstanceOf(TrackingDetails::class)
        ->identifier->toBe('abcdefg')
        ->status->toBe(Status::Unknown);
});

it('can call `find` on the default ParcelTrap driver', function () {
    $client = ParcelTrap::make(['null' => NullDriver::make([])]);
    $client->setDefaultDriver('null');

    expect($client->find('abcdefg'))->toBeInstanceOf(TrackingDetails::class);
});
