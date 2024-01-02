<?php

namespace App\Model\Enum;

use App\Model\Enum\Interface\Choosable;
use App\Model\Enum\Interface\Queryable;

/**
 * Enumerates the number of bits used to represent each transmitted character of data.
 */
enum DataBit: int implements Choosable, Queryable
{
    /**
     * Represents 7 data bits.
     */
    case SEVEN = 7;

    /**
     * Represents 8 data bits.
     */
    case EIGHT = 8;

    public static function choices(): array
    {
        return array_map(fn (DataBit $dataBit): string => (string) $dataBit->name, self::instances());
    }

    public static function instances(): array
    {
        return [
            self::SEVEN,
            self::EIGHT,
        ];
    }

    public static function getByName(string $name): DataBit
    {
        return match ($name) {
            self::SEVEN->name => self::SEVEN,
            self::EIGHT->name => self::EIGHT,
        };
    }
}
