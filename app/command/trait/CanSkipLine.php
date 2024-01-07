<?php

namespace App\Command\Trait;

use Symfony\Component\Console\Output\OutputInterface;

trait CanSkipLine
{
    /**
     * Skips a line in the output.
     *
     * @param OutputInterface $output
     * @param int $times The number of times to skip a line.
     * @return void
     */
    private function skipLine(OutputInterface $output, int $times = 1): void
    {
        for ($i = 0; $i < $times; $i++) {
            $output->writeln('');
        }
    }
}
