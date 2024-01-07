<?php

declare(strict_types=1);

namespace Tests\Command;

require_once 'vendor/autoload.php';
require_once 'helpers.php';

use App\Command\SendData;
use App\Model\Enum\Parity;
use App\Model\Enum\FlowControl;
use PHPUnit\Framework\TestCase;
use App\Command\CreateSerialConnection;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CreateSerialConnectionAndSendDataTest extends TestCase
{
    /**
     * Test case to verify if a serial connection can be established and data can be sent to the connected device.
     */
    public function testCanEstablishSerialConnectionAndSendDataToTheConnectedDevice(): void
    {
        $app = new Application();

        $createSerialConnectionCommand = $app->add(new CreateSerialConnection());

        // SendData command relies on CreateSerialConnection.
        // It is consequently tested when CreateSerialConnection is executed.
        $app->add(new SendData());

        $tester = new CommandTester($createSerialConnectionCommand);

        // Input stream follows the order of questions asked during the interactive command execution.
        $tester->setInputs([
            // This is the port I use on my Windows machine.
            'port' => 'COM4',

            // This is the baud rate that is also set on my connected device.
            // See Baud::class for the baud rates available.
            // The value corresponds to the choice index in the array.
            'baud' => 4,

            // This is the data bit that is also set on my connected device.
            // See DataBit::class for the data bits available.
            // The value corresponds to the choice index in the array.
            'data_bit' => 1,

            // The flow control constant value aligns with the choice index in the array.
            'flow_control' => FlowControl::XON_XOFF->value,

            // This is the parity that is also set on my connected device.
            // The parity constant value aligns with the choice index in the array.
            'parity' => Parity::NONE->value,

            // This is the stop bit that is also set on my connected device.
            // See StopBit::class for the stop bits available.
            'stop_bit' => 0,

            // This is the time to wait between transmissions, in seconds.
            'wait' => 1,

            // This is the data for the connected device, sent byte by byte.
            'data' => 'Greetings, Device.',
        ]);

        $tester->execute([], [
            'interactive' => true,
            'capture_stderr_separately' => true,
        ]);

        $tester->assertCommandIsSuccessful();
    }
}
