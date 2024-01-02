<?php

namespace App\Command;

use App\Model\Enum\Baud;
use App\Model\Enum\Mode;
use App\Model\Enum\Parity;
use App\Model\Enum\DataBit;
use App\Model\Enum\StopBit;
use Core\SingletonRegistry;
use App\Model\SerialConnector;
use App\Model\Enum\FlowControl;
use App\Command\Trait\CanSkipLine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

#[AsCommand(
    name: 'app:serial-connect',
    description: 'Establishes a connection to a connected device via serial communication.',
    aliases: [
        'app:sc',
        'a:sc',
    ],
    hidden: false
)]
class CreateSerialConnection extends Command
{
    use CanSkipLine;

    /**
     * @var QuestionHelper Helper to ask questions to the user.
     */
    private QuestionHelper $questionHelper;

    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setHelp(<<<HELP
                The app:serial-connect command facilitates the establishment of a serial connection with a connected device.
                Use the following options to configure the connection:

                + port: Specify the port to connect to (e.g., com4).
                + baud: Set the baud rate for communication (e.g., 9600).
                + data_bit: Define the data bit to use (e.g., 8).
                + flow_control: Specify the flow control mechanism (e.g., XON/XOFF).
                + parity: Set the parity for communication (e.g., none).
                + stop_bit: Define the stop bit to use (e.g., 1).
                + wait: Set the time to wait between transmissions, in seconds (e.g., 3).
            HELP)
            ->addArgument('port', InputArgument::REQUIRED, 'Specify the port to connect to.')
            ->addArgument('baud', InputArgument::REQUIRED, 'Set the baud rate to use.')
            ->addArgument('data_bit', InputArgument::REQUIRED, 'Define the number of data bits to use per character.')
            ->addArgument('flow_control', InputArgument::REQUIRED, 'Specify the flow control to use.')
            ->addArgument('parity', InputArgument::REQUIRED, 'Set the parity to use.')
            ->addArgument('stop_bit', InputArgument::REQUIRED, 'Define the stop bit to use.')
            ->addArgument('wait', InputArgument::OPTIONAL, 'Set the time to wait between transmissions, in seconds (default: 3).');
    }

    /**
     * Interacts with the user.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->questionHelper = $this->getHelper('question');

        $portQuestion = new Question(question: 'Specify the serial port for connection: ');

        $baudQuestion = (new ChoiceQuestion(
            question: 'Choose the baud rate for communication:',
            choices: Baud::choices()
        ))
            ->setErrorMessage('Baud rate %s is invalid.')
            ->setMaxAttempts(3);

        $dataBitQuestion = (new ChoiceQuestion(
            question: 'Choose the quantity of data bits to utilize per character:',
            choices: DataBit::choices()
        ))
            ->setErrorMessage('%s data bits is invalid.')
            ->setMaxAttempts(3);

        $flowControlQuestion = (new ChoiceQuestion(
            question: 'Choose a flow control mechanism for use:',
            choices: FlowControl::choices()
        ))
            ->setErrorMessage('Flow control %s is invalid.')
            ->setMaxAttempts(3);

        $parityQuestion = (new ChoiceQuestion(
            question: 'Choose a parity setting for use:',
            choices: Parity::choices()
        ))
            ->setErrorMessage('Parity %s is invalid.')
            ->setMaxAttempts(3);

        $stopBitQuestion = (new ChoiceQuestion(
            question: 'Choose a stop bit for use:',
            choices: StopBit::choices()
        ))
            ->setErrorMessage('Stop bit %s is invalid.')
            ->setMaxAttempts(3);

        $waitQuestion = (new Question(
            question: 'Specify a time interval to wait between transmissions, in seconds (default: 3): '
        ))
            ->setValidator(function (?string $value) {
                if ($value === null || (is_numeric($value) && $value > 0)) {
                    return $value;
                } else {
                    throw new \RuntimeException('The wait time must be a number greater than 0.');
                }
            })
            ->setMaxAttempts(3);

        $port = $this->questionHelper->ask($input, $output, $portQuestion);
        $this->skipLine($output);

        $baud = $this->questionHelper->ask($input, $output, $baudQuestion);
        $this->skipLine($output);

        $dataBit = $this->questionHelper->ask($input, $output, $dataBitQuestion);
        $this->skipLine($output);

        $flowControl = $this->questionHelper->ask($input, $output, $flowControlQuestion);
        $this->skipLine($output);

        $parity = $this->questionHelper->ask($input, $output, $parityQuestion);
        $this->skipLine($output);

        $stopBit = $this->questionHelper->ask($input, $output, $stopBitQuestion);
        $this->skipLine($output);

        $wait = $this->questionHelper->ask($input, $output, $waitQuestion);
        $this->skipLine($output);

        $input->setArgument('port', $port);
        $input->setArgument('baud', $baud);
        $input->setArgument('data_bit', $dataBit);
        $input->setArgument('flow_control', $flowControl);
        $input->setArgument('parity', $parity);
        $input->setArgument('stop_bit', $stopBit);
        $input->setArgument('wait', $wait);
    }

    /**
     * Executes the current command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int The command exit code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $port = $input->getArgument('port');
        $baud = $input->getArgument('baud');
        $dataBit = $input->getArgument('data_bit');
        $flowControl = $input->getArgument('flow_control');
        $parity = $input->getArgument('parity');
        $stopBit = $input->getArgument('stop_bit');
        $wait = is_null($input->getArgument('wait')) ? $input->getArgument('wait') : (int) $input->getArgument('wait');

        try {
            $connector = new SerialConnector(
                port: $port,
                baud: Baud::getByName($baud),
                dataBit: DataBit::getByName($dataBit),
                flowControl: FlowControl::getByName($flowControl),
                parity: Parity::getByName($parity),
                stopBit: StopBit::getByName($stopBit),
                wait: $wait
            );

            if ($connector->open(Mode::READING_AND_WRITING)) {
                SingletonRegistry::register(SerialConnector::class, $connector);

                $output->writeln('Connection established successfully.');
                $this->skipLine($output);
            }

            return $this->getApplication()->doRun(new ArrayInput(['command' => 'app:serial-send']), $output);
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());

            return Command::FAILURE;
        }
    }
}
