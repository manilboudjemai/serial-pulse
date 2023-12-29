<?php

namespace App\Model;

use App\Model\Enum\ConnectionState;

/**
 * Represents a serial connection.
 */
class SerialConnection
{
    /**
     * @var ConnectionState $state The state of the serial connection.
     */
    protected ConnectionState $state;

    /**
     * @var resource|false $stream The stream of the serial connection; false if the connection is not open.
     */
    protected mixed $stream;

    /**
     * @var int|null $id The ID of the serial connection; null if the connection is not open.
     */
    protected ?int $id;

    /**
     * @var string|null $type The type of the serial connection; null if the connection is not open.
     */
    protected ?string $type;

    /**
     * SerialConnection constructor.
     *
     * @param ConnectionState $state The state of the serial connection.
     * @param int|null $id The ID of the serial connection.
     * @param string|null $type The type of the serial connection.
     */
    public function __construct(
        ConnectionState $state = ConnectionState::UNSET,
        ?int $id = null,
        ?string $type = null
    )
    {
        $this->state = $state;
        $this->stream = false;
        $this->id = $id;
        $this->type = $type;
    }

    /**
     * Performs cleanup operations; closes the serial connection.
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Writes data into the currently open serial connection.
     *
     * @param string $data The data to be written into the open serial connection.
     * @return bool Returns true if the data was successfully written into the open serial connection.
     *              Returns false if the data could not be written.
     * @throws \Exception If the serial connection is not open when the method is called.
     */
    public function write(string $data): bool
    {
        if (! $this->isOpen()) {
            throw new \Exception("The serial connection is not open; cannot write data.");
        }

        return fwrite($this->stream, $data) !== false;
    }

    /**
     * Closes the serial connection.
     *
     * @return bool Returns true if the connection is successfully closed, false otherwise.
     */
    public function close(): bool
    {
        if (! $this->stream || $this->isUnset()) {
            return true;
        }

        if (fclose($this->stream)) {
            $this->state = ConnectionState::UNSET;
            $this->stream = false;
            $this->id = null;
            $this->type = null;

            return true;
        }

        return false;
    }

    ### CHECKS ###

    /**
     * Checks if the connection is unset.
     *
     * @return bool Returns true if the connection is unset, false otherwise.
     */
    public function isUnset(): bool
    {
        return $this->state === ConnectionState::UNSET;
    }

    /**
     * Checks if the connection is set.
     *
     * @return bool Returns true if the connection is set, false otherwise.
     */
    public function isSet(): bool
    {
        return $this->state === ConnectionState::SET;
    }

    /**
     * Checks if the connection is open.
     *
     * @return bool Returns true if the connection is open, false otherwise.
     */
    public function isOpen(): bool
    {
        return $this->state === ConnectionState::OPEN;
    }

    ### SETTERS ###

    /**
     * Sets the state of the serial connection.
     *
     * @param ConnectionState $state The new state of the connection.
     * @return void
     */
    public function setState(ConnectionState $state): void
    {
        $this->state = $state;
    }

    /**
     * Sets the stream of the serial connection.
     *
     * @param resource|false $stream The new stream of the connection; false if the connection is not open.
     * @return void
     */
    public function setStream(mixed $stream): void
    {
        $this->stream = $stream;
    }

    /**
     * Sets the ID of the serial connection.
     *
     * @param int|null $id The new ID of the connection; null if the connection is not open.
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Sets the type of the serial connection.
     *
     * @param string|null $type The new type of the connection; null if the connection is not open.
     * @return void
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    ### GETTERS ###

    /**
     * Returns the stream of the serial connection.
     *
     * @return resource|false The stream of the serial connection; false if the connection is not open.
     */
    public function getStream(): mixed
    {
        return $this->stream;
    }
}
