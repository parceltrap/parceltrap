<?php

declare(strict_types=1);

namespace ParcelTrap\Exceptions;

use ParcelTrap\Contracts\ParcelTrapException;

class InvalidArgumentException extends \InvalidArgumentException implements ParcelTrapException {}
