<?php

namespace App\Model\Enum;

/**
 * Enumerates different configurations for the number of stop bits in serial communication.
 */
enum StopBit: int
{
    /**
     * Represents a single stop bit.
     */
    case ONE = 1;

    /**
     * Represents two stop bits.
     */
    case TWO = 2;
}
