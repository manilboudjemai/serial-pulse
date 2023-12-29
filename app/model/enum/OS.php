<?php

namespace App\Model\Enum;

/**
 * Enumerates the operating systems supported by the application.
 *
 * WARN: This enum only contains the operating systems that are currently supported by the application.
 */
enum OS: int
{
    case WINDOWS = 0;

    /**
     * Returns the currently running operating system.
     *
     * @return OS The currently running operating system.
     * @throws \Exception If the current operating system is not supported.
     */
    public static function getRunning(): OS
    {
        return match (strtoupper(PHP_OS)) {
            "WIN32", "WINNT", "WINDOWS" => OS::WINDOWS,
            default => throw new \Exception("The current operating system is not supported."),
        };
    }

    /**
     * Returns the code for the given operating system.
     *
     * @param OS $os The operating system.
     * @return string The code for the operating system.
     * @throws \Exception If no code is available for the given operating system.
     */
    public static function getCode(OS $os): string
    {
        return match ($os) {
            OS::WINDOWS => "WIN",
            default => throw new \Exception("No code for the given operating system."),
        };
    }

    /**
     * Check if the current operating system is Windows.
     *
     * @return bool Returns true if the current operating system is Windows, false otherwise.
     */
    public static function isWin(): bool
    {
        return OS::getRunning() === OS::WINDOWS;
    }

    /**
     * Check if the given port is compatible with the current operating system.
     *
     * @param string $port The port to check for compatibility with the current operating system.
     * @return bool Returns true if the port is compatible with the current operating system, false otherwise.
     */
    public function isCompatiblePort(string $port): bool
    {
        return match ($this) {
            OS::WINDOWS => preg_match('@^COM(\\d+)$@i', $port) === 1,
            default => false,
        };
    }
}
