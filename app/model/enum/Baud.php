<?php

namespace App\Model\Enum;

/**
 * Enumerates the standard baud rates commonly used in serial communication.
 */
enum Baud: int
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
}
