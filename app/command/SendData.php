<?php

namespace App\Command;

use Core\SingletonRegistry;
use App\Model\SerialConnector;
use App\Command\Trait\CanSkipLine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:serial-send',
    description: 'Transmits data to a connected device.',
    aliases: [
        'app:ss',
        'a:ss',
    ],
    hidden: true
)]
class SendData extends Command
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
        $this->setHelp('Transmit data to a connected device.')
            ->addArgument('data', InputArgument::REQUIRED, 'The data you want to transmit to the connected device.');
    }

    /**
     * Interacts with the user.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->questionHelper = $this->getHelper('question');

        $dataQuestion = (new Question(
            question: 'Input the data you want to transmit to the connected device: '
        ))->setValidator(function (?string $value) {
            if ($value === null || strlen($value) < 1) {
                throw new \RuntimeException('The data must exist; something must be transmitted to the connected device.');
            }

            return $value;
        })->setMaxAttempts(3);

        $data = $this->questionHelper->ask($input, $output, $dataQuestion);

        $this->skipLine($output);

        $input->setArgument('data', $data);

        return Command::SUCCESS;
    }

    /**
     * Executes the current command.
     *
     * Sending data one character at a time is chosen for the following reasons:
     *
     * + ensure synchronization between the sender (PHP side) and the receiver (connected device).
     * + prevent overflow issues, particularly if the connected device has a limited buffer size.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int The command exit code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $data = $input->getArgument('data');
            $steps = strlen($data);

            ($progressBar = new ProgressBar($output, max: $steps))->start();

            $step = -1;
            while (++$step < $steps) {
                SingletonRegistry::get(SerialConnector::class)->send($data[$step]);

                $progressBar->advance();
            }

            $progressBar->finish();

            $this->skipLine($output, times: 2);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());

            return Command::FAILURE;
        }
    }
}
