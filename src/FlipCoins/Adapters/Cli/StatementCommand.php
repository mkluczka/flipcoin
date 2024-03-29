<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Adapters\Cli;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\ReadModel\Statement\StatementReadModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatementCommand extends Command
{
    public function __construct(private readonly StatementReadModel $statementReadModel)
    {
        parent::__construct('flipcoin:Statement');
    }

    #[\Override]
    protected function configure(): void
    {
        parent::configure();

        $this->addArgument('customerName', InputArgument::REQUIRED);
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $customerName = $input->getArgument('customerName');

        $output->writeln("<comment>Statement</comment> $customerName");

        $view = $this->statementReadModel->getForCustomer(new CustomerId($customerName));

        $table = new Table($output);
        $table->setStyle('box');
        $table->setHeaders(['Statements']);
        $table->setRows(array_map(fn($row) => [$row], $view));
        $table->render();

        return self::SUCCESS;
    }
}
