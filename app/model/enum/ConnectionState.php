<?php

namespace App\Model\Enum;

/**
 * Enumerates the different states of a connection.
 */
enum ConnectionState: int
{
    /**
     * Represents the state when the connection is not yet established.
     */
    case UNSET = 0;

    /**
     * Represents the state when the connection parameters are set but the connection is not yet open.
     */
    case SET = 1;

    /**
     * Represents the state when the connection is open and ready for communication.
     */
    case OPEN = 2;
}
