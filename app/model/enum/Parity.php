<?php

namespace App\Model\Enum;

use App\Model\Enum\Interface\Choosable;
use App\Model\Enum\Interface\Queryable;

/**
 * Enumerates different types of parity used in serial communication.
 */
enum Parity: int implements Choosable, Queryable
{
    /**
     * Represents no parity.
     */
    case NONE = 0;

    /**
     * Represents odd parity.
     */
    case ODD = 1;

    /**
     * Represents even parity.
     */
    case EVEN = 2;

    /**
     * Evaluates the specified parity type and returns the command to execute for configuring the serial port with the
     * specified parity.
     *
     * @param Parity $parity The parity type.
     * @return string The command to execute for configuring the serial port with the specified parity.
     */
    public static function getCommands(Parity $parity): string
    {
        return match ($parity) {
            Parity::NONE => 'N',
            Parity::ODD => 'O',
            Parity::EVEN => 'E',
        };
    }

    public static function choices(): array
    {
        return array_map(fn (Parity $parity): string => (string) $parity->name, self::instances());
    }

    public static function instances(): array
    {
        return [
            self::NONE,
            self::ODD,
            self::EVEN,
        ];
    }

    public static function getByName(string $name): Parity
    {
        return match ($name) {
            self::NONE->name => self::NONE,
            self::ODD->name => self::ODD,
            self::EVEN->name => self::EVEN,
        };
    }
}
