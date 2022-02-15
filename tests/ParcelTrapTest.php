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

it('can add multiple drivers to ParcelTrap', function () {
    $client = ParcelTrap::make(['null' => NullDriver::make([])]);
    $client->addDriver('null2', NullDriver::make([]));

    expect($client)->hasDriver('null2')->toBeTrue();
});

it('can retrieve a driver from ParcelTrap', function () {
    expect(ParcelTrap::make(['null' => NullDriver::make([])]))
        ->hasDriver('null')->toBeTrue()
        ->driver('null')->toBeInstanceOf(NullDriver::class);
});

it('throws an exception when a driver can\'t be found in ParcelTrap', function () {
    ParcelTrap::make([])->driver('abc');
})->throws(InvalidArgumentException::class);

it('can set a default ParcelTrap driver', function () {
    $client = ParcelTrap::make(['null' => NullDriver::make([])]);
    $client->setDefaultDriver('null');

    expect($client->getDefaultDriver())->toBe('null');
    expect($client->driver())->toBeInstanceOf(NullDriver::class);
});

it('throws an exception when attempting to set a non-existant default driver in ParcelTrap', function () {
    ParcelTrap::make([])->setDefaultDriver('null');
})->throws(InvalidArgumentException::class);

it('throws an exception when a default driver hasn\'t been set in ParcelTrap', function () {
    ParcelTrap::make([])->driver();
})->throws(InvalidArgumentException::class);

it('can call `find` on a ParcelTrap driver', function () {
    expect(ParcelTrap::make(['null' => NullDriver::make([])])->driver('null')->find('abcdefg'))
        ->toBeInstanceOf(TrackingDetails::class)
        ->identifier->toBe('abcdefg')
        ->status->toBe(Status::Unknown)
        ->status->description()->toBe('Unknown')
        ->summary->toBe('This is a summary for the null driver')
        ->estimatedDelivery->toEqual(new DateTimeImmutable('2022-01-01'));
});

it('can call `find` on the default ParcelTrap driver', function () {
    $client = ParcelTrap::make(['null' => NullDriver::make([])]);
    $client->setDefaultDriver('null');

    expect($client->find('abcdefg'))->toBeInstanceOf(TrackingDetails::class);
});
