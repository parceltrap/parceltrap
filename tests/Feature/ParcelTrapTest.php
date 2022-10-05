<?php

declare(strict_types=1);

use Illuminate\Contracts\Config\Repository;
use ParcelTrap\Drivers\NullDriver;
use ParcelTrap\DTOs\TrackingDetails;
use ParcelTrap\Enums\Status;
use ParcelTrap\ParcelTrap;

it('can instantiate ParcelTrap', function () {
    expect($this->app->get(ParcelTrap::class))->toBeInstanceOf(ParcelTrap::class);
});

it('can add multiple drivers to ParcelTrap', function () {
    $client = $this->app->get(ParcelTrap::class);
    $client->extend('null2', function () {
        return new NullDriver();
    });

    expect($client)->driver('null2')->toBeInstanceOf(NullDriver::class);
});

it('can retrieve a driver from ParcelTrap', function () {
    expect($this->app->get(ParcelTrap::class))
        ->driver('null')->toBeInstanceOf(NullDriver::class);
});

it('throws an exception when a driver can\'t be found in ParcelTrap', function () {
    $this->app->get(ParcelTrap::class)->driver('abc');
})->throws(InvalidArgumentException::class);

it('can set a default ParcelTrap driver', function () {
    config()->set('parceltrap.default', 'null');

    $client = $this->app->get(ParcelTrap::class);

    expect($client->getDefaultDriver())->toBe('null')
        ->and($client->driver())->toBeInstanceOf(NullDriver::class);
});

it('throws an exception when a default driver hasn\'t been set in ParcelTrap', function () {
    $this->app->get(Repository::class)->set('parceltrap.default', null);

    $this->app->get(ParcelTrap::class)->driver();
})->throws(InvalidArgumentException::class, 'A default ParcelTrap driver has not been configured');

it('can call `find` on a ParcelTrap driver', function () {
    expect($this->app->get(ParcelTrap::class)->driver('null')->find('abcdefg'))
        ->toBeInstanceOf(TrackingDetails::class)
        ->identifier->toBe('abcdefg')
        ->status->toBe(Status::Unknown)
        ->status->description()->toBe('Unknown')
        ->summary->toBe('This is a summary for the null driver')
        ->estimatedDelivery->toEqual(new DateTimeImmutable('2022-01-01'));
});

it('can call `find` on the default ParcelTrap driver', function () {
    $client = $this->app->get(ParcelTrap::class);

    expect($client->find('abcdefg'))->toBeInstanceOf(TrackingDetails::class);
});
