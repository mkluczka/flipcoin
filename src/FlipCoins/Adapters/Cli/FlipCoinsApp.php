<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Adapters\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('flipcoin:app')]
final class FlipCoinsApp extends Command
{
    /** @var string[] */
    private const array FORBIDDEN_COMMANDS = ['app'];

    private const string DEFAULT_COMMANDS = <<<TEXT
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
        Offer2
        Overview
        TEXT;

    protected function configure(): void
    {
        parent::configure();

        $this->addArgument('commands', InputArgument::OPTIONAL, 'App commands', self::DEFAULT_COMMANDS);
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $commands = explode("\n", $input->getArgument('commands'));

        foreach ($commands as $command) {
            if (in_array($command, self::FORBIDDEN_COMMANDS, true)) {
                $output->writeln("<error>Command `$command` is fobidden</error>");
                continue;
            }

            try {
                $this->getApplication()->doRun(new StringInput("flipcoin:$command"), $output);
            } catch (CommandNotFoundException) {
                $output->writeln("<error>Unknown command `$command`</error> (skipped)");
            }
        }

        return self::SUCCESS;
    }
}
