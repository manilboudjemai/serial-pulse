<?php

namespace App\Model;

use App\Model\Enum\Baud;
use App\Model\Enum\Parity;
use App\Model\Enum\DataBit;
use App\Model\Enum\StopBit;
use App\Model\Enum\FlowControl;

/**
 * Represents a serial configuration.
 */
class SerialConfig
{
    /**
     * @var string $port The name of the serial port of the serial connection.
     */
    protected string $port;

    /**
     * @var Baud $baud The baud rate for the serial connection.
     */
    protected Baud $baud;

    /**
     * @var DataBit $dataBit The data bit setting for the serial connection.
     */
    protected DataBit $dataBit;

    /**
     * @var FlowControl $flowControl The flow control setting for the serial connection.
     */
    protected FlowControl $flowControl;

    /**
     * @var Parity $parity The parity type setting for the serial connection.
     */
    protected Parity $parity;

    /**
     * @var StopBit $stopBit The stop bit configuration for the serial connection.
     */
    protected StopBit $stopBit;

    /**
     * SerialConfig constructor.
     *
     * @param string $port The port to connect to.
     * @param Baud $baud The baud rate for the serial connection.
     * @param DataBit $dataBit The data bit setting for the serial connection.
     * @param FlowControl $flowControl The flow control setting for the serial connection.
     * @param Parity $parity The parity type setting for the serial connection.
     * @param StopBit $stopBit The stop bit configuration for the serial connection.
     */
    private function __construct(
        string $port,
        Baud $baud,
        DataBit $dataBit,
        FlowControl $flowControl,
        Parity $parity,
        StopBit $stopBit
    )
    {
        $this->port = $port;
        $this->baud = $baud;
        $this->dataBit = $dataBit;
        $this->flowControl = $flowControl;
        $this->parity = $parity;
        $this->stopBit = $stopBit;
    }

    /**
     * SerialConfig factory method.
     *
     * @param string $port The port to connect to.
     * @param Baud $baud The baud rate for the serial connection.
     * @param DataBit $dataBit The data bit setting for the serial connection.
     * @param FlowControl $flowControl The flow control setting for the serial connection.
     * @param Parity $parity The parity type setting for the serial connection.
     * @param StopBit $stopBit The stop bit configuration for the serial connection.
     */
    public static function set(
        string $port,
        Baud $baud,
        DataBit $dataBit,
        FlowControl $flowControl,
        Parity $parity,
        StopBit $stopBit
    ): SerialConfig
    {
        return new SerialConfig(
            port: $port,
            baud: $baud,
            dataBit: $dataBit,
            flowControl: $flowControl,
            parity: $parity,
            stopBit: $stopBit
        );
    }

    ### GETTERS ###

    /**
     * Returns the port to connect to.
     *
     * @return string The port to connect to.
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * Returns the baud rate for the serial connection.
     *
     * @return Baud The baud rate for the serial connection.
     */
    public function getBaud(): Baud
    {
        return $this->baud;
    }

    /**
     * Returns the data bit setting for the serial connection.
     *
     * @return DataBit The data bit setting for the serial connection.
     */
    public function getDataBit(): DataBit
    {
        return $this->dataBit;
    }

    /**
     * Returns the flow control setting for the serial connection.
     *
     * @return FlowControl The flow control setting for the serial connection.
     */
    public function getFlowControl(): FlowControl
    {
        return $this->flowControl;
    }

    /**
     * Returns the parity type setting for the serial connection.
     *
     * @return Parity The parity type setting for the serial connection.
     */
    public function getParity(): Parity
    {
        return $this->parity;
    }

    /**
     * Returns the stop bit configuration for the serial connection.
     *
     * @return StopBit The stop bit configuration for the serial connection.
     */
    public function getStopBit(): StopBit
    {
        return $this->stopBit;
    }
}
