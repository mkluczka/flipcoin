<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\UI\Cli;

use MKluczka\FlipCoins\Application\Offer2\Offer2;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class Offer2Command extends Command
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
        parent::__construct('flipcoin:Offer2');
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<comment>Offer2</comment>');

        $this->messageBus->dispatch(new Offer2());

        return self::SUCCESS;
    }
}
