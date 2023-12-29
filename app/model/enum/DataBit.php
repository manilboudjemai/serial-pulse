<?php

namespace App\Model\Enum;

/**
 * Enumerates the number of bits used to represent each transmitted character of data.
 */
enum DataBit: int
{
    /**
     * Represents 7 data bits.
     */
    case SEVEN = 7;

    /**
     * Represents 8 data bits.
     */
    case EIGHT = 8;
}
