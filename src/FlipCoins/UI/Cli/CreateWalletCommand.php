<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\UI\Cli;

use MKluczka\FlipCoins\Application\CreateWallet\CreateWallet;
use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Money\Money;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateWalletCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
        parent::__construct('flipcoin:CreateWallet');
    }

    #[\Override]
    protected function configure(): void
    {
        parent::configure();

        $this
            ->addArgument('customerName', InputArgument::REQUIRED)
            ->addArgument('initialAmount', InputArgument::REQUIRED);
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $customerName = $input->getArgument('customerName');
        $initialAmount = $input->getArgument('initialAmount');

        $output->writeln(
            '<comment>CreateWallet</comment> ' . $customerName . ' ' . $initialAmount
        );

        $this->messageBus->dispatch(
            new CreateWallet(
                new CustomerId($customerName),
                Money::fromDecimal($initialAmount)
            )
        );

        return self::SUCCESS;
    }
}
