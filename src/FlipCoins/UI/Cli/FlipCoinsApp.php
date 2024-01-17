<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\UI\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('flipcoin:app')]
final class FlipCoinsApp extends Command
{
    private const string INPUT = <<<TEXT
        CreateWallet Harry 100
        CreateWallet Ron 95.7
        CreateWallet Hermione 104
        CreateWallet Albus 200
        CreateWallet Draco 500
        Overview
        TransferMoney Albus Draco 30
        TransferMoney Hermione Harry 2
        TransferMoney Albus Ron 5
        Overview
        Statement Harry
        Statement Albus
        Overview
        TEXT;

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $commands = explode("\n", self::INPUT);

        foreach ($commands as $command) {
            try {
                $this->getApplication()->doRun(new StringInput("flipcoin:$command"), $output);
            } catch (CommandNotFoundException) {
                $output->writeln("<error>Unknown command `$command`</error> (skipped)");
            }
        }

        return self::SUCCESS;
    }
}
