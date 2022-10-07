<?php

declare(strict_types=1);

use ParcelTrap\Exceptions\ApiAuthenticationFailedException;
use ParcelTrap\Exceptions\ApiLimitReachedException;
use ParcelTrap\Facades\ParcelTrap;

it('can build the exception class for when the api limit is exceeded', function () {
    $exception = null;

    try {
        ParcelTrap::find('MOCK-API-LIMIT-EXCEEDED');
    } catch (ApiLimitReachedException $exception) {
    }

    expect($exception)->toBeInstanceOf(ApiLimitReachedException::class);
    expect($exception->getLimit())->toBe(10);
    expect($exception->getPeriod())->toBe('minute');
    expect($exception->getDriver())->toBe(ParcelTrap::driver());
    expect($exception->getMessage())->toBe('The API limit of 10 requests per minute has been reached for the Null driver');
});

it('can build the exception class for when the api authentication fails', function () {
    $exception = null;

    try {
        ParcelTrap::find('MOCK-AUTHENTICATION-FAILED');
    } catch (ApiAuthenticationFailedException $exception) {
    }

    expect($exception)->toBeInstanceOf(ApiAuthenticationFailedException::class);
    expect($exception->getDriver())->toBe(ParcelTrap::driver());
    expect($exception->getMessage())->toBe('The API authentication failed for the Null driver');
});
