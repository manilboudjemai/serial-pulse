<?php

namespace App\Model;

use App\Model\Enum\OS;
use App\Model\Enum\Baud;
use App\Model\Enum\Mode;
use App\Model\Enum\Parity;
use App\Model\Enum\DataBit;
use App\Model\Enum\StopBit;
use App\Model\Enum\FlowControl;
use App\Model\SerialConnection;
use App\Model\Enum\ConnectionState;

/**
 * Provides an interface for serial communication between a computer and a device.
 */
class SerialConnector
{
    /**
     * @var OS $os The operating system of the computer.
     */
    protected OS $os;

    /**
     * @var SerialConfig $config The configuration for the serial connection.
     */
    protected SerialConfig $config;

    /**
     * @var int $wait The duration, in seconds, to pause between successive transmissions.
     */
    protected int $wait;

    /**
     * @var SerialConnection $connection The serial connection.
     */
    protected SerialConnection $connection;

    /**
     * @var resource|false $process A resource object representing the executed process when configuring the serial
     *                              connection.
     */
    protected mixed $process;

    /**
     * SerialConnector constructor.
     *
     * @param string $port The port to connect to.
     * @param Baud $baud The baud rate for the serial connection.
     * @param DataBit $dataBit The data bit setting for the serial connection.
     * @param FlowControl $flowControl The flow control type set for the serial connection.
     * @param Parity $parity The parity type set for the serial connection.
     * @param StopBit $stopBit The stop bit configuration for the serial connection.
     * @param int $wait The duration, in seconds, to pause between successive transmissions.
     *
     * @throws \Exception If the operating system is not supported.
     */
    public function __construct(
        string $port,
        Baud $baud = Baud::RATE_9600,
        DataBit $dataBit = DataBit::EIGHT,
        FlowControl $flowControl = FlowControl::NONE,
        Parity $parity = Parity::NONE,
        StopBit $stopBit = StopBit::ONE,
        int $wait = 3
    )
    {
        if (OS::isWin()) {
            $this->os = OS::WINDOWS;

            $this->config = SerialConfig::set(
                port: strtoupper($port),
                baud: $baud,
                dataBit: $dataBit,
                flowControl: $flowControl,
                parity: $parity,
                stopBit: $stopBit
            );

            $this->wait = $wait;
            $this->connection = new SerialConnection();
            $this->process = null;

            $this->set();

            return;
        }

        throw new \Exception("This application is not supported on this operating system : " . PHP_OS . ".");
    }

    /**
     * Performs cleanup operations; closes the serial connection and terminates the configuration process.
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Sets up the serial connection to the specified port.
     *
     * @return bool Returns true if the connection is successfully set up, otherwise throws an exception.
     * @throws \Exception If the connection is already set or open, or if the connection cannot be set.
     */
    private function set(): true
    {
        if ($this->connection->isSet()) {
            throw new \Exception("The connection is already set.");
        } elseif ($this->connection->isOpen()) {
            throw new \Exception("The connection is open; it must be closed before it can be (re)set.");
        }

        if ($this->os->isCompatiblePort($this->config->getPort())) {
            $port = $this->config->getPort();
            $baud = $this->config->getBaud()->value;
            $parity = Parity::getCommands($this->config->getParity());
            $dataBit = $this->config->getDataBit()->value;
            $stopBit = $this->config->getStopBit()->value;
            $flowControl = FlowControl::getCommands($this->config->getFlowControl());

            if ($this->execute(
                "mode $port BAUD=$baud PARITY=$parity DATA=$dataBit STOP=$stopBit $flowControl",
                [
                    0 => ['pipe', 'w'],
                    1 => ['pipe', 'r'],
                    2 => ['pipe', 'r'],
                ]
            )) {
                $this->connection->setState(ConnectionState::SET);

                return true;
            }

            throw new \Exception("Unable to set the connection to the serial port.");
        }

        throw new \Exception("The port is not compatible with the current operating system.");
    }

    /**
     * Executes a command with the given descriptors.
     *
     * @param string $cmd The command to execute.
     * @param array $descriptors An array of descriptors for the command.
     * @return bool Returns true if the command was executed successfully, false otherwise.
     */
    private function execute(string $cmd, array $descriptors): bool
    {
        $this->process = proc_open($cmd, $descriptors, $pipes);

        return is_resource($this->process);
    }

    /**
     * Opens a connection to a serial port for reading and/or writing.
     *
     * @param Mode $mode The mode in which to open the connection (e.g., read, write, or both).
     * @return bool Returns true if the connection is successfully opened.
     * @throws \Exception If the connection is already open, not set, or cannot be opened.
     */
    public function open(Mode $mode): bool
    {
        if ($this->connection->isUnset()) {
            throw new \Exception("The connection cannot be opened because it is not set.");
        } elseif ($this->connection->isOpen()) {
            throw new \Exception("The connection is already open; it must be closed before it can be opened again.");
        }

        $this->connection->setStream(fopen($this->config->getPort(), $mode->value));

        if (is_resource($this->connection->getStream())) {
            $this->connection->setState(ConnectionState::OPEN);
            $this->connection->setId(get_resource_id($this->connection->getStream()));
            $this->connection->setType(get_resource_type($this->connection->getStream()));

            return true;
        }

        throw new \Exception("Unable to open the connection to the serial port.");
    }

    /**
     * Sends data to the connected device via the serial port.
     *
     * @param string $data The data to be sent.
     * @return bool Returns true if the data is successfully sent.
     * @throws \Exception If the data cannot be sent.
     */
    public function send(string $data): bool
    {
        if ($this->wait > 0) {
            sleep($this->wait);
        }

        if ($this->connection->write($data)) {
            return true;
        } else {
            throw new \Exception("Unable to send the data.");
        }
    }

    /**
     * Closes the connection to the serial port.
     *
     * @return bool Returns true if the connection is successfully closed, or if the connection is already closed.
     * @throws \Exception If the connection cannot be closed.
     */
    private function close(): bool
    {
        if ($this->connection === null) {
            return true;
        }

        if ($this->connection->close()) {
            unset($this->connection);

            proc_close($this->process);

            dd("Connection closed.");

            return true;
        }

        throw new \Exception("Unable to close the serial connection.");
    }

    ### GETTERS ###

    /**
     * Checks if the connection is unset.
     *
     * @return bool Returns true if the connection is unset, false otherwise.
     */
    public function connectionIsUnset(): bool
    {
        return $this->connection->isUnset();
    }

    /**
     * Checks if the connection is set.
     *
     * @return bool Returns true if the connection is set, false otherwise.
     */
    public function connectionIsSet(): bool
    {
        return $this->connection->isSet();
    }

    /**
     * Checks if the connection is open.
     *
     * @return bool Returns true if the connection is open, false otherwise.
     */
    public function connectionIsOpen(): bool
    {
        return $this->connection->isOpen();
    }
}
