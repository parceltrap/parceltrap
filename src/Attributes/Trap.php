<?php

declare(strict_types=1);

namespace ParcelTrap\Attributes;

use Attribute;
use BackedEnum;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\ContextualAttribute;
use ParcelTrap\Contracts\Driver;
use ParcelTrap\ParcelTrap;
use UnitEnum;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Trap implements ContextualAttribute
{
    public function __construct(public string|UnitEnum $driver) {}

    public static function resolve(self $attribute, Container $container): Driver|null
    {
        // @phpstan-ignore return.type
        return $container->make(ParcelTrap::class)->driver(self::enumValue($attribute->driver));
    }

    private static function enumValue(string|UnitEnum $value): string
    {
        return (string) match (true) {
            $value instanceof BackedEnum => $value->value,
            $value instanceof UnitEnum => $value->name,
            default => $value,
        };
    }
}
