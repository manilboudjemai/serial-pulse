<?php

namespace App\Model\Enum;

/**
 * Enumerates different types of parity used in serial communication.
 */
enum Parity: int
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
}

