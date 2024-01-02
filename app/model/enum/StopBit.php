<?php

namespace App\Model\Enum;

use App\Model\Enum\Interface\Choosable;
use App\Model\Enum\Interface\Queryable;

/**
 * Enumerates different configurations for the number of stop bits in serial communication.
 */
enum StopBit: int implements Choosable, Queryable
{
    /**
     * Represents a single stop bit.
     */
    case ONE = 1;

    /**
     * Represents two stop bits.
     */
    case TWO = 2;

    public static function choices(): array
    {
        return array_map(fn (StopBit $stopBit): string => (string) $stopBit->name, self::instances());
    }

    public static function instances(): array
    {
        return [
            self::ONE,
            self::TWO,
        ];
    }

    public static function getByName(string $name): StopBit
    {
        return match ($name) {
            self::ONE->name => self::ONE,
            self::TWO->name => self::TWO,
        };
    }
}
