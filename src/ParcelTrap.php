<?php

declare(strict_types=1);

namespace ParcelTrap;

use Illuminate\Support\Manager;
use ParcelTrap\Contracts\Factory;
use ParcelTrap\Drivers\NullDriver;
use ParcelTrap\Exceptions\InvalidArgumentException;

class ParcelTrap extends Manager implements Factory
{
    public function createNullDriver(): NullDriver
    {
        return new NullDriver;
    }

    public function getDefaultDriver(): string
    {
        /** @var string|null $driver */
        $driver = $this->config->get('parceltrap.default');

        if (! is_string($driver)) {
            throw new InvalidArgumentException('A default ParcelTrap driver has not been configured');
        }

        return $driver;
    }
}
