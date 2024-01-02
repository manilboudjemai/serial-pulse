<?php

namespace App\Command\Trait;

use Symfony\Component\Console\Output\OutputInterface;

trait CanSkipLine
{
    /**
     * Skips a line in the output.
     *
     * @param OutputInterface $output
     * @return void
     */
    private function skipLine(OutputInterface $output): void
    {
        $output->writeln('');
    }
}
