<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'helpers.php';

use App\Model\Enum\Baud;
use App\Model\Enum\Mode;
use App\Model\Enum\Parity;
use App\Model\Enum\DataBit;
use App\Model\Enum\StopBit;
use App\Model\SerialConnector;
use App\Model\Enum\FlowControl;

$connector = new SerialConnector(
    port: "com4",
    baud: Baud::RATE_9600,
    dataBit: DataBit::EIGHT,
    flowControl: FlowControl::XON_XOFF,
    parity: Parity::NONE,
    stopBit: StopBit::ONE
);

$connector->open(Mode::READING_AND_WRITING);

if ($connector->connectionIsOpen()) {
    dd("Connection is open.");

    $connector->send("H");
    error_log("H\n", 3, "output.log");
    $connector->send("E");
    error_log("E\n", 3, "output.log");
    $connector->send("L");
    error_log("L\n", 3, "output.log");
    $connector->send("L");
    error_log("L\n", 3, "output.log");
    $connector->send("O");
    error_log("O\n", 3, "output.log");

    dd("All data sent.");

    unset($connector);
} elseif ($connector->connectionIsSet()) {
    dd("Connection is set.");
} elseif ($connector->connectionIsUnset()) {
    dd("Connection is unset.");
}
