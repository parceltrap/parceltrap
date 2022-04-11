<?php

declare(strict_types=1);

namespace ParcelTrap\Contracts;

interface Factory
{
    /**
     * Get a ParcelTrap driver implementation.
     *
     * @param  string  $driver
     * @return Driver
     */
    public function driver($driver = null);
}
