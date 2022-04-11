<?php

declare(strict_types=1);

use ParcelTrap\Drivers\NullDriver;
use ParcelTrap\DTOs\TrackingDetails;
use ParcelTrap\Enums\Status;
use ParcelTrap\ParcelTrap;

it('can instantiate ParcelTrap', function () {
    expect(ParcelTrap::make(['null' => new NullDriver()]))
        ->toBeInstanceOf(ParcelTrap::class);
});

it('can add multiple drivers to ParcelTrap', function () {
    $client = ParcelTrap::make(['null' => new NullDriver()]);
    $client->extend('null2', function () {
        return new NullDriver();
    });

    expect($client)->driver('null2')->toBeInstanceOf(NullDriver::class);
});

it('can retrieve a driver from ParcelTrap', function () {
    expect(ParcelTrap::make(['null' => new NullDriver()]))
        ->driver('null')->toBeInstanceOf(NullDriver::class);
});

it('throws an exception when a driver can\'t be found in ParcelTrap', function () {
    ParcelTrap::make([])->driver('abc');
})->throws(InvalidArgumentException::class);

it('can set a default ParcelTrap driver', function () {
    $client = ParcelTrap::make(['null' => new NullDriver()]);
    $client->setDefaultDriver('null');

    expect($client->getDefaultDriver())->toBe('null');
    expect($client->driver())->toBeInstanceOf(NullDriver::class);
});

it('throws an exception when a default driver hasn\'t been set in ParcelTrap', function () {
    ParcelTrap::make([])->driver();
})->throws(InvalidArgumentException::class);

it('can call `find` on a ParcelTrap driver', function () {
    expect(ParcelTrap::make(['null' => new NullDriver()])->driver('null')->find('abcdefg'))
        ->toBeInstanceOf(TrackingDetails::class)
        ->identifier->toBe('abcdefg')
        ->status->toBe(Status::Unknown)
        ->status->description()->toBe('Unknown')
        ->summary->toBe('This is a summary for the null driver')
        ->estimatedDelivery->toEqual(new DateTimeImmutable('2022-01-01'));
});

it('can call `find` on the default ParcelTrap driver', function () {
    $client = ParcelTrap::make(['null' => new NullDriver()]);
    $client->setDefaultDriver('null');

    expect($client->find('abcdefg'))->toBeInstanceOf(TrackingDetails::class);
});
