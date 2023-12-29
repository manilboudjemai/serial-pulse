<?php

namespace App\Model\Enum;

/**
 * Enumerates different modes for opening a connection to the stream of data created between the computer and the
 * connected object via the serial port.
 */
enum Mode: string
{
    /**
     * This mode opens the file for reading only and places the file pointer at the beginning of the file.
     */
    case READING_ONLY = 'r';

    /**
     * This mode opens the file for writing only, places the file pointer at the beginning of the file, and truncates
     * the file to zero length. If the file does not exist, it attempts to create it.
     */
    case WRITING_ONLY = 'w';

    /**
     * This mode opens the file for reading and writing and places the file pointer at the beginning of the file.
     */
    case READING_AND_WRITING = 'r+';
}
