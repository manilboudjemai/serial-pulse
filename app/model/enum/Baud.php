<?php

namespace App\Model\Enum;

use App\Model\Enum\Interface\Choosable;
use App\Model\Enum\Interface\Queryable;

/**
 * Enumerates the standard baud rates commonly used in serial communication.
 */
enum Baud: int implements Choosable, Queryable
{
    case RATE_300 = 300;
    case RATE_1200 = 1200;
    case RATE_2400 = 2400;
    case RATE_4800 = 4800;
    case RATE_9600 = 9600;
    case RATE_14400 = 14400;
    case RATE_19200 = 19200;
    case RATE_28800 = 28800;
    case RATE_38400 = 38400;
    case RATE_57600 = 57600;
    case RATE_115200 = 115200;
    case RATE_230400 = 230400;
    case RATE_460800 = 460800;
    case RATE_921600 = 921600;

    public static function choices(): array
    {
        return array_map(fn (Baud $baud): string => (string) $baud->name, self::instances());
    }

    public static function instances(): array
    {
        return [
            self::RATE_300,
            self::RATE_1200,
            self::RATE_2400,
            self::RATE_4800,
            self::RATE_9600,
            self::RATE_14400,
            self::RATE_19200,
            self::RATE_28800,
            self::RATE_38400,
            self::RATE_57600,
            self::RATE_115200,
            self::RATE_230400,
            self::RATE_460800,
            self::RATE_921600,
        ];
    }

    public static function getByName(string $name): Baud
    {
        return match ($name) {
            self::RATE_300->name => self::RATE_300,
            self::RATE_1200->name => self::RATE_1200,
            self::RATE_2400->name => self::RATE_2400,
            self::RATE_4800->name => self::RATE_4800,
            self::RATE_9600->name => self::RATE_9600,
            self::RATE_14400->name => self::RATE_14400,
            self::RATE_19200->name => self::RATE_19200,
            self::RATE_28800->name => self::RATE_28800,
            self::RATE_38400->name => self::RATE_38400,
            self::RATE_57600->name => self::RATE_57600,
            self::RATE_115200->name => self::RATE_115200,
            self::RATE_230400->name => self::RATE_230400,
            self::RATE_460800->name => self::RATE_460800,
            self::RATE_921600->name => self::RATE_921600,
        };
    }
}
