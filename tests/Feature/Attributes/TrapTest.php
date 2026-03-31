<?php

declare(strict_types=1);

namespace ParcelTrap\Tests\Feature\Attributes;

use ParcelTrap\Attributes\Trap;
use ParcelTrap\Contracts\Driver;
use ParcelTrap\Drivers\NullDriver;

it('can resolve the driver from contextual attribute', function () {
    /** @var TestClass $class */
    $class = $this->app->make(TestClass::class);

    expect($class)
        ->toBeInstanceOf(TestClass::class)
        ->parceltrap->toBeInstanceOf(NullDriver::class);
});

class TestClass
{
    public function __construct(
        #[Trap('null')] public Driver $parceltrap,
    ) {}
}
