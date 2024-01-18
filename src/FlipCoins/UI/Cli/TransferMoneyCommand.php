<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\UI\Cli;

use MKluczka\FlipCoins\Application\TransferMoney\TransferMoney;
use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Money\Money;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class TransferMoneyCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
        parent::__construct('flipcoin:TransferMoney');
    }

    #[\Override]
    protected function configure(): void
    {
        parent::configure();

        $this
            ->addArgument('sourceCustomer', InputArgument::REQUIRED)
            ->addArgument('targetCustomer', InputArgument::REQUIRED)
            ->addArgument('amount', InputArgument::REQUIRED);
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sourceCustomer = $input->getArgument('sourceCustomer');
        $targetCustomer = $input->getArgument('targetCustomer');
        $transferAmount = $input->getArgument('amount');

        $output->writeln("<comment>TransferMoney</comment> $sourceCustomer $targetCustomer $transferAmount");

        $this->messageBus->dispatch(
            new TransferMoney(
                new CustomerId($sourceCustomer),
                new CustomerId($targetCustomer),
                Money::fromDecimal($transferAmount),
            )
        );

        return self::SUCCESS;
    }
}
