<?php

namespace App\Model\Enum;

use App\Model\Enum\Interface\Choosable;
use App\Model\Enum\Interface\Queryable;

/**
 * Enumerates the flow control types for a serial port.
 */
enum FlowControl: int implements Choosable, Queryable
{
    /**
     * Represents no flow control.
     */
    case NONE = 0;

    /**
     * Represents software flow control using XON (transmission on) and XOFF (transmission off) characters.
     */
    case XON_XOFF = 1;

    /**
     * Represents hardware flow control using Ready To Send (RTS) and Clear To Send (CTS) signals.
     */
    case RTS_CTS = 2;

    /**
     * Represents hardware flow control using Data Terminal Ready (DTR) and Data Set Ready (DSR) signals.
     */
    case DTR_DSR = 3;

    /**
     * Evaluates the specified flow control type and returns the command to execute for configuring the serial port
     * with the specified flow control type.
     *
     * @param FlowControl $flowControl The flow control type.
     * @return string The command to execute for configuring the serial port with the specified flow control type.
     */
    public static function getCommands(FlowControl $flowControl): string
    {
        return match ($flowControl) {
            FlowControl::NONE => "XON=off RTS=off DTR=off",
            FlowControl::XON_XOFF => "XON=on RTS=off DTR=off",
            FlowControl::RTS_CTS => "XON=off RTS=on DTR=off",
            FlowControl::DTR_DSR => "XON=off RTS=off DTR=on",
        };
    }

    public static function choices(): array
    {
        return array_map(fn (FlowControl $flowControl): string => (string) $flowControl->name, self::instances());
    }

    public static function instances(): array
    {
        return [
            self::NONE,
            self::XON_XOFF,
            self::RTS_CTS,
            self::DTR_DSR,
        ];
    }

    public static function getByName(string $name): FlowControl
    {
        return match ($name) {
            self::NONE->name => self::NONE,
            self::XON_XOFF->name => self::XON_XOFF,
            self::RTS_CTS->name => self::RTS_CTS,
            self::DTR_DSR->name => self::DTR_DSR,
        };
    }
}
