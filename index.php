<?php

declare(strict_types=1);

require_once 'helpers.php';

require_once 'app/model/SerialConnector.php';

require_once 'app/model/enum/OS.php';
require_once 'app/model/enum/Baud.php';
require_once 'app/model/enum/Mode.php';
require_once 'app/model/enum/Parity.php';
require_once 'app/model/enum/DataBit.php';
require_once 'app/model/enum/StopBit.php';
require_once 'app/model/enum/FlowControl.php';

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
    error_log("H\r", 3, "output.log");
    $connector->send("E");
    error_log("E\r", 3, "output.log");
    $connector->send("L");
    error_log("L\r", 3, "output.log");
    $connector->send("L");
    error_log("L\r", 3, "output.log");
    $connector->send("O");
    error_log("O\r", 3, "output.log");

    dd("All data sent.");

    unset($connector);
} elseif ($connector->connectionIsSet()) {
    dd("Connection is set.");
} elseif ($connector->connectionIsUnset()) {
    dd("Connection is unset.");
}
