<?php

declare(strict_types=1);

namespace ParcelTrap;

use Illuminate\Support\Manager;
use ParcelTrap\Contracts\Factory;
use ParcelTrap\Drivers\NullDriver;

class ParcelTrap extends Manager implements Factory
{
    public function createNullDriver(): NullDriver
    {
        return new NullDriver();
    }

    public function getDefaultDriver(): string
    {
        return $this->config->get('parceltrap.default') ?? throw new \InvalidArgumentException(
            'A default ParcelTrap driver has not been configured'
        );
    }
}
